import * as character from '../actions/character.actions';
import {Character} from '../entities/character';
import {AbstractAction} from "../actions/abstract.actions";

export interface State {
    character: Character
}

const initialState: State = {
    character: new Character()
};

export function reducer(state = initialState, action: AbstractAction): State {
    switch (action.type) {
        case character.CharacterActionTypes.SELECT_COLOR: {
            return Object.assign(
                {},
                state,
                Object.assign(
                    {},
                    state.character,
                    {
                        type: action.payload
                    }
                )
            );
        }
        case character.CharacterActionTypes.SELECT_NAME: {
            return Object.assign(
                {},
                state,
                Object.assign(
                    {},
                    state.character,
                    {
                        name: action.payload
                    }
                )
            );
        }
        default:
            return state;
    }
}

export const getCharacterType = (state: State) => state.character.type;
export const getCharacterName = (state: State) => state.character.name;
