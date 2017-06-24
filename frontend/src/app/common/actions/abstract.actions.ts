import {Action} from "@ngrx/store";

export interface AbstractAction extends Action {
    payload?: any;
}
