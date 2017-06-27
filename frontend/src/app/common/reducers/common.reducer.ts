import * as common from '../actions/common.actions';
import {AbstractAction} from "../actions/abstract.actions";

export interface State {
    gameStarted: boolean,
    apiToken: string,
    endGame: boolean,
    scoreList: any
}

const initialState: State = {
    gameStarted: false,
    apiToken: null,
    endGame: false,
    scoreList: null
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
        case common.CommonActionTypes.SCORE_LIST: {
            return Object.assign(
                {},
                state,
                {
                    scoreList: action.payload
                }
            );
        }
        case common.CommonActionTypes.RESTART: {
            return Object.assign(
                {},
                initialState,
                {
                    scoreList: state.scoreList,
                    gameStarted: true
                }
            );
        }
        default:
            return state;
    }
}

export const getStartedGame = (state: State) => state.gameStarted;
