import {Component, OnInit} from '@angular/core';
import {DownloadService} from "./download.service";
import {DownloadItem} from "./download-item";

@Component({
  selector: 'download',
  templateUrl: 'download.component.html',
  providers: [DownloadService]
})

export class DownloadComponent implements OnInit {

    downloads           : DownloadItem[];
    downloadsSeeding    : DownloadItem[];
    downloadsDone       : DownloadItem[];
    downloadsInProgress : DownloadItem[];


    constructor(
      private downloadService: DownloadService
    ){ }

    getDownloads() : void {
        this.downloadService.getDownloads()
            .then(downloads => {
                console.log( downloads);
              this.downloads            = downloads;
              this.downloadsSeeding     = downloads.filter(download => download.downloadTask.status === 'seeding');
              this.downloadsDone        = downloads.filter(download => download.downloadTask.status === 'done');
              this.downloadsInProgress  = downloads.filter(download => download.downloadTask.status === 'downloading');
            })
            .catch(error => console.error(error));
    }

    cleanDone() : void {
        this.downloadService.cleanDone()
            .then(cleanedDownloadIds => {
                this.downloads        = this.downloads.filter(        download => cleanedDownloadIds.indexOf( download.downloadTask.id) < 0);
                this.downloadsDone    = this.downloadsDone.filter(    download => cleanedDownloadIds.indexOf( download.downloadTask.id) < 0);
                this.downloadsSeeding = this.downloadsSeeding.filter( download => cleanedDownloadIds.indexOf( download.downloadTask.id) < 0);
            })
            .catch(error => console.error(error));
    }

    ngOnInit() {
        this.getDownloads();
    }

}

