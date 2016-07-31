import {Component, OnInit} from '@angular/core';
import {FileSystemService, FileInfo, DirectoryPart, DirectoryInfo} from './file-system.service';

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

            <div class="panel panel-primary" style="height: 250px">
                <div class="panel-heading" style="cursor: pointer" (click)="getDirectoryInfo(fileInfo.path)">
                    {{fileInfo.name}}
                </div>
                <div class="panel-body">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <img *ngIf="fileInfo.image" [src]="fileInfo.image" width="100px" />
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <p class="text-primary">{{fileInfo.path}}</p>
                        infos...
                    </div>
                </div>
            </div>

    </div>
</div>
    `,
    providers : [FileSystemService]

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

