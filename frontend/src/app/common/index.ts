import {storeLogger} from "ngrx-store-logger";
import * as fromCharacter from "./reducers/character.reducer"
import * as fromCommon from "./reducers/common.reducer"

import {compose} from "@ngrx/core";
import {combineReducers} from "@ngrx/store";
import {loadState} from "./localStorage";

export interface AppState {
    character: fromCharacter.State
}
export const reducers = {
    character: fromCharacter.reducer,
    common: fromCommon.reducer
};

const developmentReducer: Function = compose(storeLogger(), combineReducers)(reducers);

export function metaReducer(state: any, action: any) {
    let loadedState = loadState();
    if (loadedState) {
        state = loadedState;
    }

    return developmentReducer(state, action);
}

export const getCharacterState = (state: AppState) => state.character;
