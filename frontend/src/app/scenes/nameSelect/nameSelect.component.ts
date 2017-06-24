import {Component, Input, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import * as actions from './../../common/actions/character.actions';
import {Character, CharacterTypes} from "../../character/character.model";
import {Router} from "@angular/router";
import {CharacterService} from "../../character/character.service";

@Component({
    selector: 'scene-name-select',
    templateUrl: './nameSelect.component.html',
    styleUrls: ['./nameSelect.component.css'],
    providers: [CharacterService]
})
export class NameSelectComponent implements OnInit {
    name: string;
    type: string;

    constructor(private store: Store<fromRoot.AppState>,
                private router: Router,
                private characterService: CharacterService) {
    }

    ngOnInit(): void {
        this.store.select('character').subscribe((state: Character) => {
            if (!state.type) {
                this.router.navigateByUrl('/');
            }
            this.type = state.type;
        });
    }

    setName(event: any): void { // without type info
        this.name = event.target.value;
    }

    next(): void {
        //@TODO do validation
        this.characterService.createCharacter(this.createCharacter())
            .then((backendCharacter: Character) => {
                this.store.dispatch(new actions.SelectCharacterColor(backendCharacter.type));
                this.store.dispatch(new actions.SelectCharacterName(backendCharacter.name));
            });
    }

    private createCharacter(): Character {
        let character = new Character();
        character.name = this.name;
        character.type = this.type;

        return character;
    }
}
