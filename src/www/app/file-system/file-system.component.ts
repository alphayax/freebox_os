import { Component, OnInit } from '@angular/core';
import { FileSystemService, DirectoryPart, DirectoryInfo } from './file-system.service';
import { FileInfoComponent } from "./file-info/file-info.component";
import { FileInfo } from "./file-info";

@Component({
    selector: 'file-system',
    templateUrl : 'app/file-system/file-system.component.html',
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

