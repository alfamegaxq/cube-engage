import {Component, Input, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import {Router} from "@angular/router";
import {State as CommonState} from "../../common/reducers/common.reducer";
import {State as CharacterState} from "../../common/reducers/character.reducer";
import {Stats} from "../../common/entities/stats";

@Component({
    selector: 'scene-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.css'],
})
export class HomeComponent implements OnInit {

    stats: Stats;

    constructor(private store: Store<fromRoot.AppState>, private router: Router) {
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
}
