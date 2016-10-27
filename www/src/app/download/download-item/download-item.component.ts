import {Component, Input, Output, OnInit, EventEmitter} from '@angular/core';
import {DownloadItem} from "../download-item";
import {Router} from "@angular/router";
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../../shared/freehub-api.service";
import {PosterService} from "../../shared/poster.service";

@Component({
    selector: 'download-item',
    templateUrl: 'download-item.component.html',
    providers : [
        PosterService,
    ],
})

export class DownloadItemComponent implements OnInit {

    uid: string;

    @Input()
    downloadItem: DownloadItem;

    @Output()
    onRemove = new EventEmitter<DownloadItem>();

    constructor(
        private freeHubApiService : FreehubApiService,
        private posterService : PosterService,
        private router: Router,
        public  af: AngularFire,
    ){ }

    ngOnInit() {
        this.af.auth.subscribe( auth => {
            this.uid = auth ? auth.uid : null;
            this.getPoster();
        });
    }

    getPoster() {
        if( this.downloadItem.image){
            return;
        }
        this.posterService.getImage( this.downloadItem.movieTitle.cleanName)
        .then( poster => {
            this.downloadItem.image = poster;
        });
    }

    clearDownload() {
        this.freeHubApiService.send( 'download', 'clear_id', {
            "id" : this.downloadItem.downloadTask.id,
            "uid": this.uid
        }).then( downloadItem => {
            this.onRemove.emit( downloadItem);
        });
    }

    private updateStatus( status : string){
        this.freeHubApiService.send( 'download', 'update_id', {
            "uid"    : this.uid,
            "id"     : this.downloadItem.downloadTask.id,
            "status" : status
        }).then( download => {
            this.downloadItem = download;
            this.getPoster();
        });
    }

    pauseDownload() {
        this.updateStatus( 'pause');
    }

    resumeDownload() {
        this.updateStatus( 'download');
    }

    retryDownload() {
        this.updateStatus( 'retry');
    }

    navigate() {
        this.router.navigate(['/file-system', this.uid, btoa( this.downloadItem.path)]);
    }

    isSeeding(){
        return this.downloadItem.downloadTask.status === 'seeding';
    }

    isDownloaded(){
        return this.downloadItem.downloadTask.status === 'done';
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

