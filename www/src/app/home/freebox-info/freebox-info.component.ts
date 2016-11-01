import {Component, Input, OnInit} from '@angular/core';
import { FreehubApiService} from "../../shared/freehub-api.service";
import {AngularFire} from "angularfire2";
import {FreeboxStatus} from "./freebox-status";
import {Router} from "@angular/router";


@Component({
    selector: 'freebox-info',
    templateUrl: 'freebox-info.component.html',
})

export class FreeboxInfoComponent implements OnInit {

    @Input()
    uid: string;

    @Input()
    name: string;

    freeboxStatus: FreeboxStatus;

    constructor(
        private freeHubApiService : FreehubApiService,
        private router: Router,
        public  af: AngularFire,
    ){ }

    ngOnInit() {
        this.getStatus();
    }


    getStatus(){
        this.freeHubApiService.send( 'freebox', 'get_status_from_uid', {
            "uid" : this.uid
        }).then( freeboxStatus => {
            console.log( freeboxStatus);
            this.freeboxStatus = freeboxStatus;
        });
    }

    navigate( uid, path){
        this.router.navigate(['/file-system', uid, btoa( path)]);
    }
}
