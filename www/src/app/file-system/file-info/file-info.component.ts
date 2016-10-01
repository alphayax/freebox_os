import {Component, Input, ViewChild} from '@angular/core';
import { FileInfo } from "../file-info";
import {FileSystemService} from "../file-system.service";
import {Router} from "@angular/router";

@Component({
    selector: 'file-info',
    templateUrl: 'file-info.component.html',
})

export class FileInfoComponent {

    @Input()
    fileInfo: FileInfo;

    @ViewChild('mavideo') mavideo;

    url: string;

    constructor(
        private router: Router,
        private fileSystemService: FileSystemService
    ){ }

    navigate( path){
        this.router.navigate(['/file-system', btoa( path)]);
    }

    isStreamable(){
        return (
            this.fileInfo.fileInfo.mimetype === 'video/ogg' ||
            this.fileInfo.fileInfo.mimetype === 'video/mp4' ||
            this.fileInfo.fileInfo.mimetype === 'video/webm'
        );
    }

    playInBrowser( path) {
        this.fileSystemService.getShareLink( path)
            .then( shareLink => {
                let link = ['/player', btoa( shareLink.url), btoa( this.fileInfo.fileInfo.mimetype)];
                this.router.navigate(link);
            })
    }

    directDownload( ) {

    }
}
