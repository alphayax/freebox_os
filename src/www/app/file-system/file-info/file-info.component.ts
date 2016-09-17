import {Component, Input, ViewChild} from '@angular/core';
import { FileInfo } from "../file-info";
import {FileSystemService} from "../file-system.service";
import {Router} from "@angular/router";

@Component({
    selector: 'file-info',
    templateUrl: 'app/file-system/file-info/file-info.component.html',
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

    playInBrowser( path) {
        this.fileSystemService.getShareLink( path)
            .then( shareLink => {
                let link = ['/player', btoa( shareLink.url), btoa( this.fileInfo.fileInfo.mimetype)];
                this.router.navigate(link);
            })
    }
}

