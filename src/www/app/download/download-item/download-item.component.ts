import { Component, Input } from '@angular/core';
import { DownloadItem } from "../download-item";
import { DownloadItemService } from "./download-item.service";

@Component({
  selector: 'download-item',
  templateUrl: 'app/download/download-item/download-item.component.html',
  providers: [DownloadItemService]
})

export class DownloadItemComponent {

  error: any;

  @Input()
  downloadItem: DownloadItem;

  constructor(
      private downloadItemService: DownloadItemService
  ){ }

  clearDownload(){

    this.downloadItemService.cleanFromId( this.downloadItem.downloadTask.id)
        .then(downloads => {
          console.log( downloads);
        })
        .catch(error => this.error = error);
  }

  pauseDownload(){

    this.downloadItemService.pauseFromId( this.downloadItem.downloadTask.id)
        .then(downloads => {
          console.log( downloads);
        })
        .catch(error => this.error = error);
  }

  public getRxPct() : number {
    return this.downloadItem.downloadTask.rx_pct / 100;
  }

  public getTxPct() : number {
    return this.downloadItem.downloadTask.tx_pct / 100;
  }

  public getCleanName() : string {
    return this.downloadItem.name;
  }

  public getImage(){
    return this.downloadItem.image;
  }

}

