import * as common from '../actions/common.actions';
import {AbstractAction} from "../actions/abstract.actions";

export interface State {
    gameStarted: boolean,
    apiToken: string
}

const initialState: State = {
    gameStarted: false,
    apiToken: null
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
        default:
            return state;
    }
}

export const getStartedGame = (state: State) => state.gameStarted;
