import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";

import {RssSearch} from "./rss-search";

import 'rxjs/add/operator/toPromise';


@Injectable()
export class DlRssService {


  constructor(
      private http: Http
  ) { }

  // Todo : Mettre l'url a jour
  private action_getList = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download_dlrss&action=get_list';
  private action_checkFromId = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=download_dlrss&action=check_from_id';

    checkRss( downloadId) {

        let headers = new Headers();
            headers.append('Content-Type', 'application/json');

        let params = JSON.stringify({
            'id' : downloadId
        });
        return this.http.post(this.action_checkFromId, params, headers)
               .toPromise()
               .then(response => response.json().data as string[])
               .catch(DlRssService.handleError);
    }

    getPatterns(){

        let headers = new Headers();
        headers.append('Content-Type', 'application/json');

        return this.http.post(this.action_getList, '', headers)
            .toPromise()
            .then(response => response.json().data as RssSearch[])
            .catch(DlRssService.handleError);
    }

    private static handleError(error: any) {
    console.error('An error occurred', error);
    return Promise.reject(error.message || error);
  }

}

