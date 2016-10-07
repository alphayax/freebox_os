import {Component} from '@angular/core';
import {HomeService} from "./home.service";
import { AngularFire,AuthMethods,AuthProviders } from 'angularfire2';

@Component({
    selector: 'home',
    templateUrl: 'home.component.html',
    providers: [HomeService]
})

export class HomeComponent {

    freeboxInfos : string[];
    error: any;
    values:Array<any>;

    constructor(
        private homeService : HomeService,
        public  af: AngularFire,
    ){}

    getFreeboxInfo( uid) {
        console.log( uid);
        this.homeService.getFreeboxInfo( uid)
            .then(freeboxInfos => {
                this.freeboxInfos = freeboxInfos;
                console.log(freeboxInfos);
            })
            .catch(error => this.error = error);
    }

    ngOnInit() {
        this.af.auth.subscribe(auth => {

            // User is logged
            if( auth) {
                let tempArray=[];
                for(let key in auth){
                    tempArray.push(auth[key]);
                    console.log( key, auth[key]);
                }
                this.values=tempArray;
                this.getFreeboxInfo( auth.uid);
            }

        });
    }

    login() {
        this.af.auth.login({
            provider: AuthProviders.Google,
            method: AuthMethods.Popup,
        });
    }

    logout(){
        this.af.auth.logout();
    }
}

