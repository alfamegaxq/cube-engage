import {Action} from '@ngrx/store';
import {AbstractAction} from "./abstract.actions";

/* Layout actions are defined here */
export const CommonActionTypes = {
    START_GAME: '[Common] Start game',
    SET_API_TOKEN: '[Common] Set api token',
};

export class StartGame implements AbstractAction {
    type = CommonActionTypes.START_GAME;

    constructor(public payload?: string) {
    }
}

export class SetApiToken implements AbstractAction {
    type = CommonActionTypes.SET_API_TOKEN;

    constructor(public payload?: string) {
    }
}
