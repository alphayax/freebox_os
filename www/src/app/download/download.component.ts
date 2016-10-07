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
  error: any;


  constructor(
      private downloadService: DownloadService
  ){ }

  getDownloads() : void {
    this.downloadService.getDownloads()
        .then(downloads => {
          this.downloads            = downloads;
          this.downloadsSeeding     = downloads.filter(download => download.downloadTask.status === 'seeding');
          this.downloadsDone        = downloads.filter(download => download.downloadTask.status === 'done');
          this.downloadsInProgress  = downloads.filter(download => download.downloadTask.status === 'downloading');
        })
        .catch(error => this.error = error);
  }

  cleanDone() : void {
      this.downloadService.cleanDone()
          .then(downloads => {
              console.log( downloads);
          })
          .catch(error => this.error = error);
  }

  ngOnInit() {
    this.getDownloads();
  }
}
