import {Component, OnDestroy, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../common/index';
import {State as CommonState} from "../common/reducers/common.reducer";
import {Router} from "@angular/router";

@Component({
    selector: 'app-score-list',
    templateUrl: './scoreList.component.html',
    styleUrls: ['./scoreList.component.css'],
})
export class ScoreListComponent implements OnInit, OnDestroy {

    scoreList: any;
    private commonSuscription;

    constructor(private store: Store<fromRoot.AppState>) {
    }

    ngOnInit(): void {
        this.commonSuscription = this.store.select('common').subscribe((state: CommonState) => {
            this.scoreList = state.scoreList;
        });
    }

    ngOnDestroy(): void {
        this.commonSuscription.unsubscribe();
    }
}
