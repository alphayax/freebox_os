import { Component, OnInit } from '@angular/core';
import { DirectoryInfo } from './file-system.service';
import { ActivatedRoute, Params, Router } from "@angular/router";
import { FreehubApiService } from "../shared/freehub-api.service";

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

    getDirectoryInfo( path){
        this.freeHubApiService.send( 'filesystem', 'explore', {
            "path" : path
        }).then( directoryInfo => {
            this.directoryInfo = directoryInfo;
        });
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

