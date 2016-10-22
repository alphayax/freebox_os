import {Component, OnInit} from '@angular/core';
import {DownloadService} from "./download.service";
import {DownloadItem} from "./download-item";
import {AngularFire} from "angularfire2";

@Component({
  selector: 'download',
  templateUrl: 'download.component.html',
  providers: [DownloadService]
})

export class DownloadComponent implements OnInit {

    uid: string;

    downloads           : DownloadItem[];
    downloadsSeeding    : DownloadItem[];
    downloadsDone       : DownloadItem[];
    downloadsInProgress : DownloadItem[];


    constructor(
        private downloadService: DownloadService,
        public  af: AngularFire,
    ){ }

    ngOnInit() {
        this.af.auth.subscribe( auth => {
            this.uid = auth ? auth.uid : null;
            this.getDownloads();
        });
    }

    getDownloads() : void {
        this.downloadService.getDownloads( this.uid)
            .then( downloads => {
              this.downloads            = downloads;
              this.downloadsSeeding     = downloads.filter(download => download.downloadTask.status === 'seeding');
              this.downloadsDone        = downloads.filter(download => download.downloadTask.status === 'done');
              this.downloadsInProgress  = downloads.filter(download => download.downloadTask.status === 'downloading');
            })
    }

    cleanDone() : void {
        this.downloadService.cleanDone( this.uid)
            .then( cleanedDownloadIds => {
                this.downloads        = this.downloads.filter(        download => cleanedDownloadIds.indexOf( download.downloadTask.id) < 0);
                this.downloadsDone    = this.downloadsDone.filter(    download => cleanedDownloadIds.indexOf( download.downloadTask.id) < 0);
                this.downloadsSeeding = this.downloadsSeeding.filter( download => cleanedDownloadIds.indexOf( download.downloadTask.id) < 0);
            })
    }

}

