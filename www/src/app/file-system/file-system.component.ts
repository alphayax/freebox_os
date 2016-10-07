import { Component, OnInit } from '@angular/core';
import { FileSystemService, DirectoryPart, DirectoryInfo } from './file-system.service';
import { FileInfo } from "./file-info";
import {ActivatedRoute, Params, Router} from "@angular/router";

@Component({
    selector: 'file-system',
    templateUrl : 'file-system.component.html',
    providers : [FileSystemService]
})


export class FileSystemComponent implements OnInit {

    directoryInfo: DirectoryInfo;
    toto: DirectoryPart;
    files : FileInfo[];
    error: any;


    constructor(
        private fileSystemService: FileSystemService,
        private route: ActivatedRoute,
        private router: Router
    ){ }

    navigate( path){
        this.router.navigate(['/file-system', btoa( path)]);
    }

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
        this.route.params.forEach((params: Params) => {
            let path = params['path'];
            if( path){
                path = atob( path);
            } else {
                path = '/'
            }
            this.getDirectoryInfo( path);
        });
    }
}
