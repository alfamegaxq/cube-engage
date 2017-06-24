import {Component, Input} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import * as actions from './../../common/actions/character.actions';
import {Character, CharacterTypes} from "../../character/character.model";
import {Observable} from "rxjs/Observable";
import {AppState} from "../../common/index";
import {Router} from "@angular/router";

@Component({
    selector: 'scene-character-select',
    templateUrl: './characterSelect.component.html',
    styleUrls: ['./characterSelect.component.css']
})
export class CharacterSelectComponent {
    types = [];
    pageValid = null;

    constructor(private store: Store<fromRoot.AppState>, private router:Router) {
        this.types = CharacterTypes;
        this.store.select('character').subscribe((state: Character) => {
            if (state.type) {
                this.pageValid = true;
            }
        });
    }

    selectCharacter(type: string): void {
        this.store.dispatch(new actions.SelectCharacterColor(type));
    }

    next(): void {
       if(this.pageValid) {
           this.router.navigate(['register']);
       } else {
           this.pageValid = false;
       }
    }
}
