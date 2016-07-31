import {Component, OnInit} from '@angular/core';
import {DownloadService} from "./download.service";
import {DownloadItem} from "./download-item";
import {DownloadItemComponent} from "./download-item/download-item.component";

@Component({
  selector: 'download',
  templateUrl: 'app/download/download.component.html',
  directives: [DownloadItemComponent],
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

  getDownloads(){
    this.downloadService.getDownloads()
        .then(downloads => {
          this.downloads            = downloads;
          this.downloadsSeeding     = downloads.filter(download => download.downloadTask.status === 'seeding');
          this.downloadsDone        = downloads.filter(download => download.downloadTask.status === 'downloading');
          this.downloadsInProgress  = downloads.filter(download => download.downloadTask.status === 'done');
        })
        .catch(error => this.error = error);
  }

  ngOnInit() {
    this.getDownloads();
  }
}

