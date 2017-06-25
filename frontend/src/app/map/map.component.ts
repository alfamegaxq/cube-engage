import {Component, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../common/index';
import {State} from "../common/reducers/character.reducer";
import {MapService} from "./map.service";
import {Map} from "./map.model";
import {CookieService} from "ng2-cookies";

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.css'],
    providers: [MapService, CookieService]
})
export class MapComponent implements OnInit {
    map: Map;

    constructor(private store: Store<fromRoot.AppState>, private mapService: MapService) {
    }

    ngOnInit(): void {
        this.store.select('character').subscribe((state: State) => {
            this.mapService.getMap(state.stats).then((map: Map) => {
                this.map = map;
            });
        });
    }

    cellClick(row: number, col: number) {
        this.mapService.clickTile({row: row, col: col}).then((map: Map) => {
            this.map = map;
        });
    }
}
