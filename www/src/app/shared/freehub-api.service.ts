import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";

import 'rxjs/add/operator/toPromise';


@Injectable()
export class FreehubApiService {

    constructor(
      private http: Http
    ) { }

    // TODO : Récuperer le host d'un fichier de configuration
    private host = 'http://api.freehub.ondina.alphayax.com:14789';
    private endPoint = '/api.php?';

    send( service, action, params){

        let url = this.host + this.endPoint + 'service=' + service + '&action=' + action;

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        return this.http.post( url, JSON.stringify( params), { headers: headers })
               .toPromise()
               .then(response => {
                   if( response.json().success) {
                       return response.json().data;
                   } else {
                       return Promise.reject( response.json().error)
                   }
               })
               .catch(this.handleError);
    }

    private handleError(error: any) {
        console.error('Freehub Api Service : Une erreur est survenue.', error);
        return Promise.reject( error.message || error);
    }

}

