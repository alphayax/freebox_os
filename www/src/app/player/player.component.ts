import {Component, ViewChild, OnInit} from '@angular/core';
import {ActivatedRoute, Params} from "@angular/router";
import {AngularFire} from "angularfire2";

@Component({
    selector: 'player',
    templateUrl: 'player.component.html',
})

export class PlayerComponent implements OnInit {

    @ViewChild('mavideo') mavideo;

    url: string;

    mimeType: string;

    constructor(
        private route: ActivatedRoute,
        public  af: AngularFire,
    ) {}

    ngOnInit(): void {
        this.route.params.forEach((params: Params) => {
            this.url        = atob( params['url']);
            this.mimeType   = atob( params['mime']);
        });
    }

}

