import * as character from '../actions/character.actions';
import {Character} from '../entities/character';

export interface State {
    character: Character
}

const initialState: State = {
    character: new Character()
};

export function reducer(state = initialState, action: character.CharacterActions): State {
    switch (action.type) {
        case character.CharacterActionTypes.SELECT_CHARACTER: {
            return Object.assign(
                {},
                state,
                Object.assign(
                    {},
                    state.character,
                    {
                        type: action.selection,
                        name: action.name
                    }
                )
            );
        }
        default:
            return state;
    }
}

export const getCharacterType = (state: State) => state.character.type;
