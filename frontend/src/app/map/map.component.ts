import {Component} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../common/index';
import {State} from "../common/reducers/character.reducer";

@Component({
    selector: 'app-map',
    templateUrl: './map.component.html',
    styleUrls: ['./map.component.css']
})
export class MapComponent {
    size: number;

    constructor(private store: Store<fromRoot.AppState>) {
        this.store.select('character').subscribe((state: State) => {

        });
    }
}
