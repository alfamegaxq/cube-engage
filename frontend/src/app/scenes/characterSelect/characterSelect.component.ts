import {Component, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import * as actions from './../../common/actions/character.actions';
import {CharacterTypes} from "../../character/character.model";
import {Router} from "@angular/router";
import {State} from "../../common/reducers/character.reducer";

@Component({
    selector: 'scene-character-select',
    templateUrl: './characterSelect.component.html',
    styleUrls: ['./characterSelect.component.css']
})
export class CharacterSelectComponent implements OnInit{
    types = [];
    pageValid = null;
    selected = null;

    constructor(private store: Store<fromRoot.AppState>, private router:Router) {
        this.types = CharacterTypes;
    }

    ngOnInit(): void {
        this.store.select('character').subscribe((state: State) => {
            if (state.character.type) {
                this.pageValid = true;
                this.selected = state.character.type;
            }
        });
    }

    selectCharacter(type: string): void {
        this.selected = type;
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
