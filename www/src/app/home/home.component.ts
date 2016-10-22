import {Component} from '@angular/core';
import {HomeService} from "./home.service";
import { AngularFire,AuthMethods,AuthProviders } from 'angularfire2';
import {Router} from "@angular/router";

@Component({
    selector: 'home',
    templateUrl: 'home.component.html',
    providers: [HomeService]
})

export class HomeComponent {

    freeboxInfos : string[];
    error: any;
    uid: string;

    constructor(
        private homeService : HomeService,
        private router: Router,
        public  af: AngularFire,
    ){}

    ngOnInit() {
        this.af.auth.subscribe(auth => {
            if( auth) {
                this.uid = auth.uid;
                this.getFreeboxInfo( auth.uid);
            }
        });
    }

    getFreeboxInfo( uid) {
        this.homeService.getFreeboxInfo( uid)
            .then(freeboxInfos => {
                this.freeboxInfos = freeboxInfos;
            })
    }

    navigate( uid, path){
        this.router.navigate(['/file-system', uid, btoa( path)]);
    }

    login() {
        this.af.auth.login({
            provider: AuthProviders.Google,
            method: AuthMethods.Popup,
        });
    }

}

