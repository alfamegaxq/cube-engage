import {Headers, Http, Response} from "@angular/http";
import {CookieService} from "ng2-cookies";

export const ERROR_EXISTS = 'EXISTS';

export abstract class BaseApi {
    protected apiUrl = 'http://challenge.dev:8001';

    constructor(protected http: Http, protected cookies: CookieService) {
    }

    protected post<T>(url: string, payload: Object): Promise<T> {
        let body = new FormData();
        for (let property in payload) {
            if (payload.hasOwnProperty(property)) {
                body.append(property, payload[property]);
            }
        }

        let headers = new Headers();
        headers.append('X-Api-Token', this.cookies.get('apiToken'));
        headers.append('Access-Control-Allow-Credentials', 'true');

        return this.http.post(this.apiUrl + url, body, {withCredentials: true, headers: headers})
            .toPromise()
            .then((response: Response) => response.json() as T)
            .catch((e: Response) => {
                if (e.status == 409) {
                    throw {error: ERROR_EXISTS}
                }
            });
    }

    protected get<T>(url: string): Promise<T> {
        let headers = new Headers();
        headers.append('X-Api-Token', this.cookies.get('apiToken'));
        headers.append('Access-Control-Allow-Credentials', 'true');

        return this.http.get(this.apiUrl + url, {withCredentials: true, headers: headers})
            .toPromise()
            .then((response: Response) => response.json() as T);
    }
}
