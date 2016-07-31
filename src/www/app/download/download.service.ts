import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";

import 'rxjs/add/operator/toPromise';

export class Download {
    name: string;
    status: string;
}


@Injectable()
export class DownloadService {

  constructor(
      private http: Http
  ) { }

  // Todo : Mettre l'url a jour
  private exploreUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download&action=explore';

    getDownloads() {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        return this.http.post(this.exploreUrl, '', headers)
               .toPromise()
               .then(response => response.json().data as Download[])
               .catch(this.handleError);
    }

    private handleError(error: any) {
    console.error('An error occurred', error);
    return Promise.reject(error.message || error);
  }

}

