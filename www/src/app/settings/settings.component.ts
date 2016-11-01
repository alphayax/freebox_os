
import {Component, OnInit} from '@angular/core';
import { AngularFire } from 'angularfire2';
import {FreehubApiService} from "../shared/freehub-api.service";
import {FreeboxStatus} from "../home/freebox-info/freebox-status";
import {FreeboxAssociation} from "../shared/freebox-association";


@Component({
    selector: 'settings',
    templateUrl: 'settings.component.html',
})

export class SettingsComponent implements OnInit {

    freeboxInfos : FreeboxAssociation;
    freeboxStatus : FreeboxStatus;

    uid: string;

    constructor(
        private freeHubApiService : FreehubApiService,
        public  af: AngularFire,
    ) { }

    ngOnInit() {
        this.af.auth.subscribe(auth => {
            if( auth) {
                this.uid = auth.uid;
                this.getFreeboxInfo();
                this.getFreeboxStatus();
            }
        });
    }

    getFreeboxInfo() {
        this.freeHubApiService.send( 'freebox', 'get_from_uid', {
            "uid" : this.uid
        }).then( freeboxInfos => {
            console.log( freeboxInfos);
            this.freeboxInfos = freeboxInfos;
        });
    }

    getFreeboxStatus() {
        this.freeHubApiService.send( 'freebox', 'get_status_from_uid', {
            "uid" : this.uid
        }).then( freeboxStatus => {
            console.log( freeboxStatus);
            this.freeboxStatus = freeboxStatus;
        });
    }

    saveFreeboxName(){
        this.freeHubApiService.send( 'freebox', 'update_name_from_uid', {
            "uid" : this.uid,
            "name": this.freeboxInfos.name
        });
    }

}

