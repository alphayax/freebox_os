import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params, Router } from "@angular/router";
import { FreehubApiService } from "../shared/freehub-api.service";
import {DirectoryInfo} from "./directory-info";

@Component({
    selector: 'file-system',
    templateUrl : 'file-system.component.html',
})



export class FileSystemComponent implements OnInit {

    directoryInfo: DirectoryInfo;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private freeHubApiService : FreehubApiService,
    ){ }

    navigate( path){
        this.router.navigate(['/file-system', btoa( path)]);
    }

    getDirectoryInfo( uid, path){
        this.freeHubApiService.send( 'filesystem', 'explore', {
            "path" : path,
            "uid"  : uid
        }).then( directoryInfo => {
            this.directoryInfo = directoryInfo;
        });
    }

    ngOnInit() {
        this.route.params.forEach((params: Params) => {
            let path = params['path'];
            let uid  = params['uid'];
            if( path){
                path = atob( path);
            } else {
                path = '/'
            }
            this.getDirectoryInfo( uid, path);
        });
    }
}

