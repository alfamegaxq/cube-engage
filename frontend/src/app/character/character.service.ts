import {Injectable} from '@angular/core';
import {Character} from "./character.model";
import {Http, Response} from "@angular/http";

import 'rxjs/add/operator/toPromise';
import {BaseApi} from "../../api/base";

@Injectable()
export class CharacterService extends BaseApi {

    protected createUrl = '/api/player';

    constructor(protected http: Http) {
        super(http);
    }

    createCharacter(character: Character): Promise<Character> {
        return this.post<Character>(this.createUrl, character);
    }
}
