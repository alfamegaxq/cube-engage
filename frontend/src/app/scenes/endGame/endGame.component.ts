import {Component, OnDestroy, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import {State} from "../../common/reducers/character.reducer";
import {State as CommonState} from "../../common/reducers/common.reducer";
import {Stats} from "../../common/entities/stats";
import {ScoreService} from "../../scoreList/scoreList.service";
import {Score} from "../../scoreList/scoreList.model";
import * as commonActions from './../../common/actions/common.actions';
import {Router} from "@angular/router";

@Component({
    selector: 'scene-end-game',
    templateUrl: './endGame.component.html',
    styleUrls: ['./endGame.component.css'],
    providers: [ScoreService]
})
export class EndGameComponent implements OnInit, OnDestroy {
    stats: Stats;
    private characterSubscription;
    private commonSubscription;

    constructor(private store: Store<fromRoot.AppState>,
                private scoreService: ScoreService,
                private router: Router) {
    }

    ngOnInit(): void {

        this.characterSubscription = this.store.select('character').subscribe((state: State) => {
            if (state.stats.health > 0) {
                console.log('aa');

                this.router.navigateByUrl('/');
            }
            this.commonSubscription = this.store.select('common').subscribe((commonState: CommonState) => {
                if (!this.stats) {
                    this.stats = state.stats;
                    this.scoreService.getTopScore().then((scoreList: Score[]) => {
                        this.store.dispatch(new commonActions.SetScoreList(scoreList));
                        this.store.dispatch(new commonActions.Restart());
                    });
                }
            });
        });
    }

    ngOnDestroy(){
        this.characterSubscription.unsubscribe();
        this.commonSubscription.unsubscribe();
    }
}
