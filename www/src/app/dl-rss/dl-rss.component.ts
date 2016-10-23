import { Component, OnInit } from '@angular/core';
import {RssSearch} from "./rss-search";
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../shared/freehub-api.service";

@Component({
    selector: 'dl-rss',
    templateUrl: 'dl-rss.component.html',
})

export class DlRssComponent implements OnInit {

    uid: string;

    checkRssResults: string[];

    rssSearches: RssSearch[];

    constructor(
        private freeHubApiService : FreehubApiService,
        public  af: AngularFire,
    ){ }


    checkRss( id){
        this.freeHubApiService.send( 'download_dlrss', 'check_from_id', {
            "uid"    : this.uid,
            "rss_id" : id
        }).then( result => this.checkRssResults = result);
    }

    cleanResults() {
        this.checkRssResults = [];
    }

    getPatterns(){
        this.freeHubApiService.send( 'download_dlrss', 'get_list', {
        }).then( rssSearches => {
            this.rssSearches = rssSearches;
        });
    }

    ngOnInit() {
        this.af.auth.subscribe( auth => {
            this.uid = auth ? auth.uid : null;
            this.getPatterns();
        });
    }

}
