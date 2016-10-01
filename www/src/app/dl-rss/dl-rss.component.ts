import { Component, OnInit } from '@angular/core';
import { DlRssService } from "./dl-rss.service";
import {RssSearch} from "./rss-search";

@Component({
    selector: 'dl-rss',
    templateUrl: 'dl-rss.component.html',
    providers: [DlRssService]
})

export class DlRssComponent implements OnInit {

    checkRssResults: string[];

    rssSearches: RssSearch[];

    constructor(
        private dlRssService: DlRssService
    ){ }


    checkRss( id){
        this.dlRssService.checkRss( id)
            .then(result => this.checkRssResults = result);
    }

    cleanResults() {
        this.checkRssResults = [];
    }

    getPatterns(){
        this.dlRssService.getPatterns()
            .then(rssSearches => {
                this.rssSearches = rssSearches;
            });
    }

    ngOnInit() {
        this.getPatterns();
    }

}

