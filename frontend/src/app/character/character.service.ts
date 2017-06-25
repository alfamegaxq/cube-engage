import {Injectable} from '@angular/core';
import {Character} from "./character.model";
import {Http} from "@angular/http";
import {CookieService} from "ng2-cookies";

import 'rxjs/add/operator/toPromise';
import {BaseApi} from "../../api/base";
import {Stats} from "../common/entities/stats";

@Injectable()
export class CharacterService extends BaseApi {

    protected createUrl = '/api/player';
    protected characterStatsUrl = '/api/player';

    constructor(protected http: Http, protected cookies: CookieService) {
        super(http, cookies);
    }

    createCharacter(character: Character): Promise<Character> {
        return this.post<Character>(this.createUrl, character);
    }

    getStats(token: string): Promise<Stats> {
        return this.get<Stats>(`${this.characterStatsUrl}/${token}`);
    }
}
