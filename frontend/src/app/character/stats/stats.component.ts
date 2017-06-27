import {Component, OnDestroy, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import {Stats} from "../../common/entities/stats";
import {State} from "../../common/reducers/character.reducer";
import {Character} from "../../common/entities/character";

@Component({
    selector: 'character-stats',
    templateUrl: './stats.component.html',
    styleUrls: ['./stats.component.css']
})
export class StatsComponent implements OnInit, OnDestroy {
    stats: Stats;
    character: Character;
    private commonSubscription;

    constructor(private store: Store<fromRoot.AppState>) {
    }

    ngOnInit(): void {
        this.commonSubscription = this.store.select('character').subscribe((state: State) => {
            this.stats = state.stats;
            this.character = state.character;
        });
    }

    ngOnDestroy(): void {
        this.commonSubscription.unsubscribe();
    }
}
