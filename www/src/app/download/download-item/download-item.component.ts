import {Component, Input, OnInit} from '@angular/core';
import {DownloadItem} from "../download-item";
import {Router} from "@angular/router";
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../../shared/freehub-api.service";

@Component({
    selector: 'download-item',
    templateUrl: 'download-item.component.html',
})

export class DownloadItemComponent implements OnInit {

    uid: string;

    @Input()
    downloadItem: DownloadItem;

    constructor(
        private freeHubApiService : FreehubApiService,
        private router: Router,
        public  af: AngularFire,
    ){ }

    ngOnInit() {
        this.af.auth.subscribe( auth => {
            this.uid = auth ? auth.uid : null;
        });
    }

    clearDownload() {
        this.freeHubApiService.send( 'download', 'clear_id', {
            "id" : this.downloadItem.downloadTask.id,
            "uid": this.uid
        });
    }

    pauseDownload() {
        this.freeHubApiService.send( 'download', 'update_id', {
            "uid"    : this.uid,
            "id"     : this.downloadItem.downloadTask.id,
            "status" : 'pause'
        }).then( download => {
            this.downloadItem = download;
        });
    }

    resumeDownload() {
        this.freeHubApiService.send( 'download', 'update_id', {
            "uid"    : this.uid,
            "id"     : this.downloadItem.downloadTask.id,
            "status" : 'download'
        }).then( download => {
            this.downloadItem = download;
        });
    }

    retryDownload() {
        this.freeHubApiService.send( 'download', 'update_id', {
            "uid"    : this.uid,
            "id"     : this.downloadItem.downloadTask.id,
            "status" : 'retry'
        }).then( download => {
            this.downloadItem = download;
        });
    }

    navigate() {
        this.router.navigate(['/file-system', this.uid, btoa( this.downloadItem.path)]);
    }

    isStoppable() {
        return this.downloadItem.downloadTask.status !== 'stopped' && this.downloadItem.downloadTask.status !== 'error';
    }

    isResumable() {
        return this.downloadItem.downloadTask.status === 'stopped';
    }

    isRetryable() {
        return this.downloadItem.downloadTask.status === 'error';
    }

}

