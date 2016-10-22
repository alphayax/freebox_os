import {Injectable} from '@angular/core';
import {DownloadItem} from "./download-item";
import {FreehubApiService} from "../shared/freehub-api.service";


@Injectable()
export class DownloadService {

    constructor(
        private freeHubApiService : FreehubApiService,
    ) { }

    getDownloads( uid : string) : Promise<DownloadItem[]> {
        return this.freeHubApiService.send( 'download', 'explore', {
            "uid" : uid
        }).then( response => response as DownloadItem[]);
    }

    cleanDone( uid : string) : Promise<number[]> {
        return this.freeHubApiService.send( 'download', 'clear_done', {
            "uid" : uid
        }).then( response => response as number[]);
    }

}

