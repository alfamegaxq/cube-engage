import {createSelector} from 'reselect';
import {storeLogger} from "ngrx-store-logger";
import * as fromCharacter from "./reducers/character.reducer"
import {compose} from "@ngrx/core";
import {combineReducers} from "@ngrx/store";

export interface AppState {
    character: fromCharacter.State
}
export const reducers = {
    character: fromCharacter.reducer
};

const developmentReducer: Function = compose(storeLogger(), combineReducers)(reducers);

export function metaReducer(state: any, action: any) {
    return developmentReducer(state, action);
}

export const getCharacterState = (state: AppState) => state.character;
export const getCharacterColor = createSelector(getCharacterState , fromCharacter.getCharacterType);
export const getCharacterName = createSelector(getCharacterState , fromCharacter.getCharacterName);
