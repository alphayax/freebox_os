import {Injectable} from '@angular/core';
import {Http, Headers} from "@angular/http";

import 'rxjs/add/operator/toPromise';

export class DirectoryPart {
    name: string;
    path: string;
}

export class FileInfoOriginal {
    filecount : any;
    foldercount: any;
    hidden: boolean;
    index : number;
    link: boolean;
    mimetype: string;
    modification : number;
    name : string;
    path : string;
    size: number;
    target : any;
    type: string;
}

export class FileInfo {
    fileInfo : FileInfoOriginal;
    name: string;
    path: string;
}

export class DirectoryInfo {
    path: string;
    path_part: DirectoryPart;
    files : FileInfo[];
}


@Injectable()
export class FileSystemService {

  constructor(
      private http: Http
  ) { }

  // TODO : Mettre la vraie url externe
  private heroesUrl = 'http://ayx.freeboxos.fr:14789/freebox_os/api.php?service=filesystem&action=explore';

    getDirectoryInfo( path) {

        let headers = new Headers();
            headers.append('Content-Type', 'application/x-www-form-urlencoded');

        return this.http.post(this.heroesUrl, 'path='+path,{ headers: headers })
               .toPromise()
               .then(response => response.json().data as DirectoryInfo)
               .catch(this.handleError);
    }

    private handleError(error: any) {
    console.error('An error occurred', error);
    return Promise.reject(error.message || error);
  }
}

