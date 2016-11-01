import {Component} from '@angular/core';
import { AngularFire } from 'angularfire2';
import {FreehubApiService} from "../shared/freehub-api.service";

@Component({
    selector: 'home',
    templateUrl: 'home.component.html',
})

export class HomeComponent {

    freeboxInfos : string[];
    error: any;
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
            }
        });
    }

    getFreeboxInfo() {
        this.freeHubApiService.send( 'freebox', 'get_all', {
            "uid" : this.uid
        }).then( freeboxInfos => {
            this.freeboxInfos = freeboxInfos;
        });
    }
}

