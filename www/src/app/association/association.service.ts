import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";

import 'rxjs/add/operator/toPromise';



@Injectable()
export class AssociationService {

    constructor(
      private http: Http
    ) { }

    // TODO : Mettre la vraie url externe
    private config_freebox_url = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=config&action=association';

    addFreebox( association){

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        return this.http.post( this.config_freebox_url, JSON.stringify( association),{ headers: headers })
               .toPromise()
               .then(response => response.json().data)
               .catch(this.handleError);
    }

    private handleError(error: any) {
        console.error('HOME SERVICE : An error occurred', error);
        return Promise.reject(error.message || error);
    }
    
}

