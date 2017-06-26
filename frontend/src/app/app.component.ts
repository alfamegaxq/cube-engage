import {Component} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './common/index';
import {saveState} from "./common/localStorage";
import {CookieService} from "ng2-cookies";

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css'],
    providers: [CookieService]
})
export class AppComponent {

    constructor(private store: Store<fromRoot.AppState>) {
        store.subscribe((state) => {
            saveState(state);
        });
    }
}
