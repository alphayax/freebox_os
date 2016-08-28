import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";
import {DownloadItem} from "./download-item";

import 'rxjs/add/operator/toPromise';


@Injectable()
export class DownloadService {

  constructor(
      private http: Http
  ) { }

  // Todo : Mettre l'url a jour
  private exploreUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download&action=explore';
  private clearDoneUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download&action=clear_done';
  private clearFromIdUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download&action=clear_id';

    getDownloads() {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        return this.http.post(this.exploreUrl, '', headers)
               .toPromise()
               .then(response => response.json().data as DownloadItem[])
               .catch(DownloadService.handleError);
    }

    cleanDone() {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        return this.http.post(this.clearDoneUrl, '', headers)
               .toPromise()
               .then(response => response.json().data as string[])
               .catch(DownloadService.handleError);
    }

    cleanFromId( downloadId) {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        return this.http.post(this.clearFromIdUrl + '&id='+ downloadId, '', headers)
               .toPromise()
               .then(response => response.json().success as boolean)
               .catch(DownloadService.handleError);
    }

    private static handleError(error: any) {
    console.error('An error occurred', error);
    return Promise.reject(error.message || error);
  }

}

