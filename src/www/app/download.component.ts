import {Component, OnInit} from '@angular/core';
import {DownloadService, Download} from "./download.service";

@Component({
  selector: 'download',
  template: `
  <h1>Téléchargements</h1>
  <p class="lead">Liste des téléchargements !</p>
  
  <ul class="nav nav-tabs">
      <li class="active">
          <a href="#home" data-toggle="tab">Tous</a>
      </li>
      <li>
          <a href="#seed" data-toggle="tab">En partage</a>
      </li>
      <li>
          <a href="#download" data-toggle="tab">En cours</a>
      </li>
      <li>
          <a href="#done" data-toggle="tab">Terminés</a>
      </li>
  </ul>
  
  <div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="home">
          <p>Tous les téléchargements</p>
          <div *ngFor="let download of downloads">
            {{download.name}}
          </div>
      </div>
      <div class="tab-pane fade" id="seed">
          <p>Téléchargements terminés en cours de partage</p>
          <div *ngFor="let download of downloadsSeeding">
            {{download.name}}
          </div>
      </div>
      <div class="tab-pane fade" id="download">
          <p>Téléchargements en cours</p>
          <div *ngFor="let download of downloadsInProgress">
            {{download.name}}
          </div>
      </div>
      <div class="tab-pane fade" id="done">
          <p>Téléchargements Terminés</p>
          <a href="#" class="btn btn-default">Retirer les téléchargements terminées</a>
          <div *ngFor="let download of downloadsDone">
            {{download.name}}
          </div>
      </div>
  </div>
    `,
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
