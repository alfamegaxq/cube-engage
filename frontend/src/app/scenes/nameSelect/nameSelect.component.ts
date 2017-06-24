import {Component, Input, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import * as actions from './../../common/actions/character.actions';
import * as commonActions from './../../common/actions/common.actions';
import {Character, CharacterTypes} from "../../character/character.model";
import {Router} from "@angular/router";
import {CharacterService} from "../../character/character.service";
import {State} from "../../common/reducers/character.reducer";

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
        this.store.select('character').subscribe((state: State) => {

            if (!state.character.type) {
                this.router.navigateByUrl('/');
            }

            this.type = state.character.type;
        });
    }

    setName(event: any): void {
        this.name = event.target.value;
    }

    next(): void {
        //@TODO do validation
        this.characterService.createCharacter(this.createCharacter())
            .then((backendCharacter: Character) => {
                this.store.dispatch(new actions.SelectCharacterColor(backendCharacter.type));
                this.store.dispatch(new actions.SelectCharacterName(backendCharacter.name));
                this.store.dispatch(new commonActions.StartGame(null));
                this.router.navigateByUrl('/home');
            });
    }

    private createCharacter(): Character {
        let character = new Character();
        character.name = this.name;
        character.type = this.type;

        return character;
    }
}