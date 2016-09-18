import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";

import 'rxjs/add/operator/toPromise';


@Injectable()
export class DownloadItemService {

    constructor(
        private http: Http
    ) { }

    // Todo : Mettre l'url a jour
    private clearFromIdUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download&action=clear_id';
    private updateFromIdUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download&action=update_id';

    cleanFromId( downloadId) {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        let params = JSON.stringify({
            "id" : downloadId
        });

        return this.http.post( this.clearFromIdUrl, params, headers)
           .toPromise()
           .then(response => response.json().success as boolean)
           .catch(DownloadItemService.handleError);
    }

    updateFromId( downloadId, status) {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        let params = JSON.stringify({
            "id" : downloadId,
            "status" : status
        });

        return this.http.post(this.updateFromIdUrl, params, headers)
           .toPromise()
           .then(response => response.json().success as boolean)
           .catch(DownloadItemService.handleError);
    }

    private static handleError(error: any) {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    }

}

