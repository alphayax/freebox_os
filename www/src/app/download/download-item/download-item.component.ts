import {Component, Input} from '@angular/core';
import {DownloadItem} from "../download-item";
import {DownloadItemService} from "./download-item.service";
import {Router} from "@angular/router";

@Component({
    selector: 'download-item',
    templateUrl: 'download-item.component.html',
    providers: [DownloadItemService]
})

export class DownloadItemComponent {

    error: any;

    @Input()
    downloadItem: DownloadItem;

    constructor(
        private downloadItemService: DownloadItemService,
        private router: Router
    ) { }

    clearDownload() {
        this.downloadItemService.cleanFromId( this.downloadItem.downloadTask.id);
    }

    pauseDownload() {
        this.downloadItemService.updateFromId( this.downloadItem.downloadTask.id, 'pause')
            .then(download => {
                this.downloadItem = download;
            });
    }

    resumeDownload() {
        this.downloadItemService.updateFromId( this.downloadItem.downloadTask.id, 'download')
            .then(download => {
                this.downloadItem = download;
            });
    }

    retryDownload() {
        this.downloadItemService.updateFromId( this.downloadItem.downloadTask.id, 'retry')
            .then(download => {
                this.downloadItem = download;
            });
    }

    public getRxPct(): number {
        return this.downloadItem.downloadTask.rx_pct / 100;
    }

    public getTxPct(): number {
        return this.downloadItem.downloadTask.tx_pct / 100;
    }

    public getCleanName(): string {
        return this.downloadItem.name;
    }

    public getImage() {
        return this.downloadItem.image;
    }


    navigate() {
        this.router.navigate(['/file-system', btoa(this.downloadItem.path)]);
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

