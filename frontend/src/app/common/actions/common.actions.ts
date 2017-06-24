import {Action} from '@ngrx/store';
import {AbstractAction} from "./abstract.actions";

/* Layout actions are defined here */
export const CommonActionTypes = {
    START_GAME: '[Common] Start game'
};

export class StartGame implements AbstractAction {
    type = CommonActionTypes.START_GAME;

    constructor(public payload?: string) {
    }
}
