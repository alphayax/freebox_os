import {Component, OnInit} from '@angular/core';
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../shared/freehub-api.service";

@Component({
    selector: 'upload',
    templateUrl: 'upload.component.html',
})

export class UploadComponent implements OnInit {

    uid: string;

    shareLinks: any[];


    constructor(
        public  af: AngularFire,
        private freeHubApiService : FreehubApiService,
    ){ }

    ngOnInit() {
        this.af.auth.subscribe( auth => {
            this.uid = auth ? auth.uid : null;
            this.getUploads();
        });
    }

    getUploads() : void {

        this.freeHubApiService.send( 'upload', 'get_all', {
            "uid"  : this.uid
        }).then( shareLinks => {
            console.log( shareLinks);
            this.shareLinks = shareLinks;
        });
    }

    revokeAllShareLinks() : void {

    }

    revokeShareLinksFromToken( token) : void {
        this.freeHubApiService.send( 'upload', 'delete_from_token', {
            "uid"  : this.uid,
            "token": token
        }).then( data => {
            this.getUploads();
        });
    }



}

