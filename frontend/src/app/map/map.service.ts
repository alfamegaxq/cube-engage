import {Injectable} from '@angular/core';
import {Http, Response} from "@angular/http";

import 'rxjs/add/operator/toPromise';
import {BaseApi} from "../../api/base";
import {Map} from "./map.model";
import {Character} from "../common/entities/character";
import {Stats} from "../common/entities/stats";
import {CookieService} from "ng2-cookies";

@Injectable()
export class MapService extends BaseApi {

    protected getUrl = '/api/secure/map';

    constructor(protected http: Http, protected cookies: CookieService) {
        super(http, cookies);
    }

    getMap(stats: Stats): Promise<Map> {
        return this.get<Map>(this.getUrl + '/' + stats.level);
    }
}
