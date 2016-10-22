import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params, Router } from "@angular/router";
import { FreehubApiService } from "../shared/freehub-api.service";
import {DirectoryInfo} from "./directory-info";
import {AngularFire} from "angularfire2";

@Component({
    selector: 'file-system',
    templateUrl : 'file-system.component.html',
})



export class FileSystemComponent implements OnInit {

    directoryInfo: DirectoryInfo;
    uid: string;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private freeHubApiService : FreehubApiService,
        public  af: AngularFire,
    ){ }

    navigate( path){
        this.router.navigate(['/file-system', this.uid, btoa( path)]);
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
            this.uid = params['uid'];
            if( path){
                path = atob( path);
            } else {
                path = '/'
            }
            this.getDirectoryInfo( this.uid, path);
        });
    }
}

