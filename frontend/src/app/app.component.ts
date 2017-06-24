import {Component} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './common/index';
import {CharacterTypes} from "./character/character.model";

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css']
})
export class AppComponent {

    constructor(private store: Store<fromRoot.AppState>) {
    }
}
