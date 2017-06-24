import {Action} from '@ngrx/store';

/* Layout actions are defined here */
export const CharacterActionTypes = {
    SELECT_CHARACTER: '[Character] Select'
};

export class SelectCharacterAction implements Action {
    type = CharacterActionTypes.SELECT_CHARACTER;

    constructor(public payload: string) {
    }
}

export type CharacterActions = SelectCharacterAction;
