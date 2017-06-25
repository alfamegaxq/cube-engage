import {Http, Response} from "@angular/http";

export abstract class BaseApi {
    protected apiUrl = 'http://challenge.dev:8001';

    constructor(protected http: Http) {
    }

    protected post<T>(url: string, payload: Object): Promise<T> {
        let body = new FormData();
        for (let property in payload) {
            if (payload.hasOwnProperty(property)) {
                body.append(property, payload[property]);
            }
        }

        return this.http.post(this.apiUrl + url, body)
            .toPromise()
            .then((response: Response) => response.json() as T);
    }

    protected get<T>(url: string): Promise<T> {
        return this.http.get(this.apiUrl + url)
            .toPromise()
            .then((response: Response) => response.json() as T);
    }
}
