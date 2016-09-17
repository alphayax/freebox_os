import {Component, ViewChild, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from "@angular/router";

@Component({
    selector: 'player',
    templateUrl: 'app/player/player.component.html',
})

export class PlayerComponent implements OnInit {

    @ViewChild('mavideo') mavideo;

    url: string;

    mimeType: string;

    constructor(
        private route: ActivatedRoute
    ) {}

    ngOnInit(): void {
        this.route.params.forEach((params: Params) => {
            this.url        = atob( params['url']);
            this.mimeType   = atob( params['mime']);
        });
    }

}

