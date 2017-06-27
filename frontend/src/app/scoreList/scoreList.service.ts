import {Injectable} from '@angular/core';
import {Http, Response} from "@angular/http";

import 'rxjs/add/operator/toPromise';
import {BaseApi} from "../../api/base";
import {Character} from "../common/entities/character";
import {Stats} from "../common/entities/stats";
import {CookieService} from "ng2-cookies";
import {Score} from "./scoreList.model";

@Injectable()
export class ScoreService extends BaseApi {

    protected scoreListUrl = '/api/secure/score';

    constructor(protected http: Http, protected cookies: CookieService) {
        super(http, cookies);
    }

    getTopScore(): Promise<Score[]> {
        return this.post<Score[]>(this.scoreListUrl, {});
    }
}
