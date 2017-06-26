import {Component, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import {State} from "../../common/reducers/character.reducer";
import {Stats} from "../../common/entities/stats";

@Component({
    selector: 'scene-end-game',
    templateUrl: './endGame.component.html',
    styleUrls: ['./endGame.component.css'],
})
export class EndGameComponent implements OnInit{
    stats: Stats;

    constructor(private store: Store<fromRoot.AppState>) {
    }

    ngOnInit(): void {
        this.store.select('character').subscribe((state: State) => {
            this.stats = state.stats;
        });
    }
}
