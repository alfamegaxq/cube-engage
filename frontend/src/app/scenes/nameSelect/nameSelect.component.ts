import {Component, OnDestroy, OnInit} from '@angular/core';
import {Store} from "@ngrx/store";
import * as fromRoot from './../../common/index';
import * as actions from './../../common/actions/character.actions';
import * as commonActions from './../../common/actions/common.actions';
import {Character} from "../../character/character.model";
import {Router} from "@angular/router";
import {CharacterService} from "../../character/character.service";
import {State} from "../../common/reducers/character.reducer";
import {CookieService} from 'ng2-cookies';
import {Stats} from "../../common/entities/stats";
import {ERROR_EXISTS} from "api/base";

@Component({
    selector: 'scene-name-select',
    templateUrl: './nameSelect.component.html',
    styleUrls: ['./nameSelect.component.css'],
    providers: [CharacterService]
})
export class NameSelectComponent implements OnInit, OnDestroy {
    name: string;
    type: string;
    nextClicked: boolean;
    errorExists: false;

    private characterSubscription;

    constructor(private store: Store<fromRoot.AppState>,
                private router: Router,
                private characterService: CharacterService,
                private cookies: CookieService) {
    }

    ngOnInit(): void {
        this.characterSubscription = this.store.select('character').subscribe((state: State) => {

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
        this.nextClicked = true;
        if (this.name.length > 2) {
            this.dispatchCharacterDetails();
        }
    }

    private dispatchCharacterDetails(): void {
        this.characterService.createCharacter(this.createCharacter())
            .then((backendCharacter: Character) => {
                this.store.dispatch(new actions.SelectCharacterColor(backendCharacter.type));
                this.store.dispatch(new actions.SelectCharacterName(backendCharacter.name));
                this.store.dispatch(new commonActions.SetApiToken(backendCharacter.token));

                this.getCharacterStats(backendCharacter);

                this.store.dispatch(new commonActions.StartGame(null));
                this.cookies.set('apiToken', backendCharacter.token);
                this.router.navigateByUrl('/home');
            }).catch((e) => {
                if (e.error === ERROR_EXISTS) {
                    this.errorExists = e.error;
                }
            }
        );
    }

    private getCharacterStats(character: Character): void {
        this.characterService.getStats(character.token)
            .then((stats: Stats) => {
                this.store.dispatch(new actions.SetCharacterStatus(stats));
            });
    }

    private createCharacter(): Character {
        let character = new Character();
        character.name = this.name;
        character.type = this.type;

        return character;
    }

    ngOnDestroy(): void {
        this.characterSubscription.unsubscribe();
    }
}
