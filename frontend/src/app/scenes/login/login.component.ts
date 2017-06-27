import {Component} from '@angular/core';
import {Router} from "@angular/router";
import {CharacterService} from "../../character/character.service";
import {Character} from "../../character/character.model";
import {Store} from "@ngrx/store";
import * as actions from './../../common/actions/character.actions';
import * as commonActions from './../../common/actions/common.actions';
import * as fromRoot from './../../common/index';
import {CookieService} from "ng2-cookies";
import {Stats} from "../../common/entities/stats";

@Component({
    selector: 'scene-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.css'],
    providers: [CharacterService]
})
export class LoginComponent {

    name: string;

    constructor(private store: Store<fromRoot.AppState>,
                private router: Router,
                private characterService: CharacterService,
                private cookies: CookieService) {
    }

    setName(event: any) {
        this.name = event.target.value;
    }

    login() {
        this.characterService.login(this.name).then((backendCharacter: Character) => {
            this.characterService.getStats(backendCharacter.token).then((stats: Stats) => {
                this.store.dispatch(new actions.SelectCharacterColor(backendCharacter.type));
                this.store.dispatch(new actions.SelectCharacterName(backendCharacter.name));
                this.store.dispatch(new actions.SetCharacterStatus(stats));

                this.store.dispatch(new commonActions.StartGame(null));
                this.cookies.set('apiToken', backendCharacter.token);
                this.router.navigateByUrl('/home');
            });
        });
    }

}
