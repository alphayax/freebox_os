import {Component} from '@angular/core';
import { AngularFire } from 'angularfire2';
import {Router} from "@angular/router";
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
        private router: Router,
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
        this.freeHubApiService.send( 'config', 'get_freebox', {
            "uid" : this.uid
        }).then( freeboxInfos => {
            this.freeboxInfos = freeboxInfos;
        });
    }

    navigate( uid, path){
        this.router.navigate(['/file-system', uid, btoa( path)]);
    }

}

