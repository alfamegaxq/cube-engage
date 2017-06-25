import {Injectable} from '@angular/core';
import {Http, Response} from "@angular/http";

import 'rxjs/add/operator/toPromise';
import {BaseApi} from "../../api/base";
import {Map} from "./map.model";
import {Character} from "../common/entities/character";

@Injectable()
export class MapService extends BaseApi {

    protected getUrl = '/api/map';

    constructor(protected http: Http) {
        super(http);
    }

    getMap(character: Character): Promise<Map> {
        return this.get<Map>(this.getUrl, character);
    }
}
