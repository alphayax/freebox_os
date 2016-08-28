import { Component, OnInit } from '@angular/core';
import { DlRssService } from "./dl-rss.service";
import {RssSearch} from "./rss-search";

@Component({
    selector: 'dl-rss',
    templateUrl: 'app/dl-rss/dl-rss.component.html',
    providers: [DlRssService]
})

export class DlRssComponent implements OnInit {


    rssSearches: RssSearch[];

    constructor(
        private dlRssService: DlRssService
    ){ }


    checkRss( id){
        console.log(id);
        this.dlRssService.checkRss( id)
            .then(result => {
                console.log(result);
            });
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

