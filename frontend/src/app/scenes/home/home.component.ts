import {Component, Input, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import {Router} from "@angular/router";
import {State as CommonState} from "../../common/reducers/common.reducer";
import {State as CharacterState} from "../../common/reducers/character.reducer";
import {Stats} from "../../common/entities/stats";
import {MapService} from "../../map/map.service";
import * as commonActions from './../../common/actions/common.actions';

@Component({
    selector: 'scene-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.css'],
    providers: [MapService]
})
export class HomeComponent implements OnInit {

    stats: Stats;

    constructor(private store: Store<fromRoot.AppState>, private router: Router, private mapService: MapService) {
    }

    ngOnInit(): void {
        this.store.select('common').subscribe((state: CommonState) => {
            if (!state.gameStarted) {
                this.router.navigateByUrl('/');
            }
        });

        this.store.select('character').subscribe((state: CharacterState) => {
            this.stats = state.stats;
        });
    }

    exitGame(): void {
        this.mapService.deleteMap().then(() => {
            this.store.dispatch(new commonActions.Restart());
            this.router.navigateByUrl('/');
        });
    }
}
