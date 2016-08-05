import { Component, OnInit } from '@angular/core';
import { FileSystemService, DirectoryPart, DirectoryInfo } from './file-system.service';
import { FileInfoComponent } from "./file-info/file-info.component";
import { FileInfo } from "./file-info";

@Component({
    selector: 'file-system',
    template: `
<h1>Système de fichiers</h1>
<p class="lead">Liste des fichiers sur les disques connectés a la freebox</p>

<ul class="breadcrumb">
    <li *ngFor="let part of toto">
        <a style="cursor: pointer" (click)="getDirectoryInfo(part.path)">{{part.name}}</a>
    </li>
</ul>

<div class="row">
    <div *ngFor="let fileInfo of files" class="col-lg-4 col-md-6 col-sm-12">
        <file-info [fileInfo]="fileInfo"  (click)="getDirectoryInfo(fileInfo.path)"></file-info>
    </div>
</div>
    `,
    providers : [FileSystemService],
    directives : [FileInfoComponent]
})


export class FileSystemComponent implements OnInit {

    directoryInfo: DirectoryInfo;
    toto: DirectoryPart;
    files : FileInfo[];
    error: any;


    constructor(
        private fileSystemService: FileSystemService
    ){ }

    getDirectoryInfo( path){
        this.fileSystemService.getDirectoryInfo( path)
            .then(directoryInfo => {
                this.directoryInfo = directoryInfo;
                this.toto = directoryInfo.path_part;
                this.files = directoryInfo.files;
                console.log( directoryInfo);
            })
            .catch(error => this.error = error);
    }

    ngOnInit() {
        this.getDirectoryInfo( '/');
    }
}

