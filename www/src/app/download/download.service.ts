import {Injectable} from '@angular/core';
import {DownloadItem} from "./download-item";
import {FreehubApiService} from "../shared/freehub-api.service";


@Injectable()
export class DownloadService {

    constructor(
        private freeHubApiService : FreehubApiService,
    ) { }

    getDownloads() {

        return this.freeHubApiService.send( 'download', 'explore', {
        }).then( response => response as DownloadItem[]);
    }

    cleanDone() {

        return this.freeHubApiService.send( 'download', 'clear_done', {
        }).then( response => response as string[]);
    }

}

