import {AbstractAction} from "./abstract.actions";

/* Layout actions are defined here */
export const CommonActionTypes = {
    START_GAME: '[Common] Start game',
    SET_API_TOKEN: '[Common] Set api token',
    END_GAME: '[Common] End game',
    SCORE_LIST: '[Common] Score list',
    RESTART: '[Common] Restart state',
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

export class EndGame implements AbstractAction {
    type = CommonActionTypes.END_GAME;

    constructor(public payload?: string) {
    }
}

export class SetScoreList implements AbstractAction {
    type = CommonActionTypes.SCORE_LIST;

    constructor(public payload?: any) {
    }
}

export class Restart implements AbstractAction {
    type = CommonActionTypes.RESTART;

    constructor(public payload?: any) {
    }
}
