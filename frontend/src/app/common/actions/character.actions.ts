import {Action} from '@ngrx/store';
import {AbstractAction} from "./abstract.actions";

/* Layout actions are defined here */
export const CharacterActionTypes = {
    SELECT_COLOR: '[Character] Select Color',
    SELECT_NAME: '[Character] Select Name',
};

export class SelectCharacterColor implements AbstractAction {
    type = CharacterActionTypes.SELECT_COLOR;

    constructor(public payload: string) {
    }
}

export class SelectCharacterName implements AbstractAction {
    type = CharacterActionTypes.SELECT_NAME;

    constructor(public payload: string) {
    }
}
