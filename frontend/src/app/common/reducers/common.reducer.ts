import * as common from '../actions/common.actions';
import {AbstractAction} from "../actions/abstract.actions";

export interface State {
    gameStarted: boolean,
    apiToken: string,
    endGame: boolean
}

const initialState: State = {
    gameStarted: false,
    apiToken: null,
    endGame: false
};

export function reducer(state = initialState, action: AbstractAction): State {
    switch (action.type) {
        case common.CommonActionTypes.START_GAME: {
            return Object.assign(
                {},
                state,
                {
                    gameStarted: true
                }
            );
        }
        case common.CommonActionTypes.SET_API_TOKEN: {
            return Object.assign(
                {},
                state,
                {
                    apiToken: action.payload
                }
            );
        }
        case common.CommonActionTypes.END_GAME: {
            return Object.assign(
                {},
                state,
                {
                    endGame: true
                }
            );
        }
        default:
            return state;
    }
}

export const getStartedGame = (state: State) => state.gameStarted;
