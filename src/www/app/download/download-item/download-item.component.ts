import { Component, Input } from '@angular/core';
import { DownloadItem } from "../download-item";

@Component({
  selector: 'download-item',
  templateUrl: 'app/download/download-item/download-item.component.html',
})

export class DownloadItemComponent {

  @Input()
  downloadItem: DownloadItem;

  clearDownload( downloadId){
    console.log( 'Non implémenté. DlId = ' + downloadId);
    console.log( this.downloadItem);
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

