import {Component} from '@angular/core';
import {HomeService} from "./home.service";

@Component({
    selector: 'home',
    templateUrl: 'app/home/home.component.html',
    providers: [HomeService]
})

export class HomeComponent {

    freeboxInfos : string[];
    error: any;

    constructor(
        private homeService : HomeService
    ){ }

    getFreeboxInfo() {
        this.homeService.getFreeboxInfo()
            .then(freeboxInfos => {
                this.freeboxInfos = freeboxInfos;
                console.log(freeboxInfos);
            })
            .catch(error => this.error = error);
    }

    ngOnInit() {
        this.getFreeboxInfo();
    }

}

