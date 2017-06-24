import * as common from '../actions/common.actions';
import {AbstractAction} from "../actions/abstract.actions";

export interface State {
    gameStarted: boolean
}

const initialState: State = {
    gameStarted: false
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
        default:
            return state;
    }
}

export const getStartedGame = (state: State) => state.gameStarted;
