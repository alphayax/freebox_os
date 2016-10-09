import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";
import {FileInfo} from "./file-info";

import 'rxjs/add/operator/toPromise';

export class DirectoryPart {
    name: string;
    path: string;
}

export class DirectoryInfo {
    path: string;
    path_part: DirectoryPart;
    files : FileInfo[];
}

export class ShareLink {
    name : string;
    url : string;
    expire : string;
}


@Injectable()
export class FileSystemService {

    constructor(
      private http: Http
    ) { }

    // TODO : Mettre la vraie url externe
    private filesystem_explore_url = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=explore';
    private filesystem_share = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=share';
    private filesystem_synopsis = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=synopsis';

    getShareLink( path){

        let headers = new Headers();
        headers.append('Content-Type', 'application/x-www-form-urlencoded');

        return this.http.post(this.filesystem_share, 'path='+path,{ headers: headers })
            .toPromise()
            .then(response => response.json().data as ShareLink)
            .catch( this.handleError);
    }

    getDirectoryInfo( path) {

        let headers = new Headers();
            headers.append('Content-Type', 'application/x-www-form-urlencoded');

        return this.http.post(this.filesystem_explore_url, 'path='+path,{ headers: headers })
               .toPromise()
               .then(response => response.json().data as DirectoryInfo)
               .catch( this.handleError);
    }

    private handleError(error: any) {
        console.error('An error occurred', error);
        return Promise.reject(error.message || error);
    }
}

