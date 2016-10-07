import {Injectable} from '@angular/core';
import {DownloadItem} from "../download-item";
import {FreehubApiService} from "../../shared/freehub-api.service";


@Injectable()
export class DownloadItemService {

    constructor(
        private freeHubApiService : FreehubApiService,
    ) { }

    cleanFromId( downloadId) {

        return this.freeHubApiService.send( 'download', 'clear_id', {
            "id" : downloadId
        });
    }

    updateFromId( downloadId, status) : Promise<DownloadItem>{

        return this.freeHubApiService.send( 'download', 'update_id', {
            "id" : downloadId,
            "status" : status
        }).then( response => response as DownloadItem);
    }

}

