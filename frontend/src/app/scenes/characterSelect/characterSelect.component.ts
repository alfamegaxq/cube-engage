import {Component, Input} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import * as actions from './../../common/actions/character.actions';

@Component({
    selector: 'scene-character-select',
    templateUrl: './characterSelect.component.html',
    styleUrls: ['./characterSelect.component.css']
})
export class CharacterSelectComponent {
    constructor(private store: Store<fromRoot.AppState>) {
        this.store.dispatch(new actions.SelectCharacterAction('red', 'name'));
    }
}
