import {Component} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './common/index';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.css']
})
export class AppComponent {
    title = 'app';
    constructor(private store: Store<fromRoot.AppState>) {}
}
