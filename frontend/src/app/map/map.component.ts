import {Component, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../common/index';
import {State} from "../common/reducers/character.reducer";
import {State as CommonState} from "../common/reducers/common.reducer";
import {MapService} from "./map.service";
import {Map} from "./map.model";
import {CookieService} from "ng2-cookies";
import {CharacterService} from "../character/character.service";
import {Stats} from "../common/entities/stats";
import * as actions from './../common/actions/character.actions';

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.css'],
    providers: [CharacterService, MapService, CookieService]
})
export class MapComponent implements OnInit {
    map: Map;
    token: string;

    constructor(private store: Store<fromRoot.AppState>,
                private mapService: MapService,
                private characterService: CharacterService) {
    }

    ngOnInit(): void {
        this.store.select('character').subscribe((state: State) => {
            this.mapService.getMap(state.stats).then((map: Map) => {
                this.map = map;
            });
        });

        this.store.select('common').subscribe((state: CommonState) => {
            this.token = state.apiToken;
        });
    }

    cellClick(row: number, col: number) {
        this.mapService.clickTile({row: row, col: col}).then((map: Map) => {
            this.map = map;

            if (this.token) {
                this.characterService.getStats(this.token).then((stats: Stats) => {
                    this.store.dispatch(new actions.SetCharacterStatus(stats));
                });
            }
        });
    }
}
