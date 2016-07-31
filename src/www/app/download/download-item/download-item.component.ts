import { Component, Input } from '@angular/core';
import { DownloadItem } from "../download-item";

@Component({
  selector: 'download-item',
  template: `    
<div class="row" *ngIf="downloadItem">
    <div class="col-lg-2 col-md-2 col-sm-2">
        <img *ngIf="downloadItem.image" [src]="downloadItem.image" width="100px" />
    </div>

    <div class="col-lg-10 col-md-10 col-sm-10">
        <div class="row">
            <div class="col-lg-11 col-md-11 col-sm-11">
                <h4>{{downloadItem.cleanName}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="bs-component">
                    <span class="label label-success">{{downloadItem.downloadTask.type}}</span>
                    <span class="label label-default">{{downloadItem.downloadTask.status}}</span>
                    <span class="text-muted">&emsp;{{downloadItem.etaHr}}</span>
                </div>
                <div class="bs-component" style="margin-top: 10px;">
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" [style.width]="getRxPct() + '%'">{{getRxPct()}} %</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" [style.width]="getTxPct() + '%'">{{getTxPct()}} %</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                Taille : {{downloadItem.sizeHr}}<br/>
                Recu : {{downloadItem.rxTotalHr}} ({{downloadItem.downloadTask.rx_rate}} o/s)<br />
                Envoyé : {{downloadItem.txTotalHr}} ({{downloadItem.downloadTask.tx_rate}} o/s)
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="btn-group">
                    <a href="#" class="btn btn-default">Actions</a>
                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a (click)="clearDownload(downloadItem.downloadTask.id);">Enlever</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Mettre en pause</a></li>
                        <li><a href="#">Relancer</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
  `,
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

