import {Component, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../common/index';
import {State} from "../common/reducers/character.reducer";
import {State as CommonState} from "../common/reducers/common.reducer";
import {MapService} from "./map.service";
import {Map} from "./map.model";
import {CharacterService} from "../character/character.service";
import {Stats} from "../common/entities/stats";
import * as actions from './../common/actions/character.actions';
import * as commonActions from './../common/actions/common.actions';
import {Router} from "@angular/router";

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.css'],
    providers: [CharacterService, MapService]
})
export class MapComponent implements OnInit {
    map: Map;
    token: string;

    constructor(private store: Store<fromRoot.AppState>,
                private mapService: MapService,
                private characterService: CharacterService,
                private router:Router) {
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

                    if (stats.health <= 0) {
                        this.store.dispatch(new commonActions.EndGame());
                        this.router.navigateByUrl('/end-game');
                    }
                });
            }

            if (this.map.length === 0) {
                this.router.navigateByUrl('/home/(game-screen:success)');
            }


        });
    }
}
