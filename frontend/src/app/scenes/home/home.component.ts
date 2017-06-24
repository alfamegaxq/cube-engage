import {Component, Input, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import {Router} from "@angular/router";
import {State} from "../../common/reducers/common.reducer";

@Component({
    selector: 'scene-home',
    templateUrl: './home.component.html',
    styleUrls: ['./home.component.css'],
})
export class HomeComponent implements OnInit {

    constructor(private store: Store<fromRoot.AppState>, private router: Router) {
    }

    ngOnInit(): void {
        this.store.select('common').subscribe((state: State) => {
            if (!state.gameStarted) {
                this.router.navigateByUrl('/');
            }
        });
    }
}
