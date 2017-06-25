import * as character from '../actions/character.actions';
import {Character} from '../entities/character';
import {AbstractAction} from "../actions/abstract.actions";
import {Stats} from "../entities/stats";

export interface State {
    character: Character
    stats: Stats
}

const initialState: State = {
    character: new Character(),
    stats: new Stats()
};

export function reducer(state = initialState, action: AbstractAction): State {
    switch (action.type) {
        case character.CharacterActionTypes.SELECT_COLOR: {
            let newCharacter = Object.assign({}, state.character, {type: action.payload});
            return Object.assign({}, state, {character: newCharacter});
        }
        case character.CharacterActionTypes.SELECT_NAME: {
            let newCharacter = Object.assign({}, state.character, {name: action.payload});
            return Object.assign({}, state, {character: newCharacter});
        }
        case character.CharacterActionTypes.SET_STATS: {
            let newStats = Object.assign({}, state.stats, action.payload);
            return Object.assign({}, state, {stats: newStats});
        }
        default:
            return state;
    }
}
