import {Component, OnInit} from '@angular/core';
import {DownloadService, Download} from "./download.service";

@Component({
  selector: 'download',
  templateUrl: 'app/download/download.component.html',
  providers: [DownloadService]

})

export class DownloadComponent implements OnInit {

  downloads           : Download[];
  downloadsSeeding    : Download[];
  downloadsDone       : Download[];
  downloadsInProgress : Download[];
  error: any;


  constructor(
      private downloadService: DownloadService
  ){ }

  getDownloads(){
    this.downloadService.getDownloads()
        .then(downloads => {
          this.downloads            = downloads;
          this.downloadsSeeding     = downloads.filter(download => download.status === 'seeding');
          this.downloadsDone        = downloads.filter(download => download.status === 'downloading');
          this.downloadsInProgress  = downloads.filter(download => download.status === 'done');
        })
        .catch(error => this.error = error);
  }

  ngOnInit() {
    this.getDownloads();
  }
}

