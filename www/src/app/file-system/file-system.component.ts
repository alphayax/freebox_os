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
    uid_target: string;
    path: string;

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private freeHubApiService : FreehubApiService,
        public  af: AngularFire,
    ){ }

    navigate( path){
        this.router.navigate(['/file-system', this.uid_target, btoa( path)]);
    }

    getDirectoryInfo(){
        this.freeHubApiService.send( 'filesystem', 'explore', {
            "path" : this.path,
            "uid"  : this.uid_target
        }).then( directoryInfo => {
            this.directoryInfo = directoryInfo;
        });
    }

    ngOnInit() {
        this.route.params.forEach((params: Params) => {
            this.uid_target = params['uid'];
            this.path       = params['path'] ? atob( params['path']) : '/';
            this.getDirectoryInfo();
        });
    }
}

