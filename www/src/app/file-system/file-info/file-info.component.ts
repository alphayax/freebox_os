import {Component, Input, OnInit} from '@angular/core';
import { FileInfo } from "../file-info";
import { Router, Params, ActivatedRoute } from "@angular/router";
import { FreehubApiService} from "../../shared/freehub-api.service";
import {AngularFire} from "angularfire2";


@Component({
    selector: 'file-info',
    templateUrl: 'file-info.component.html',
})

export class FileInfoComponent implements OnInit {

    @Input()
    fileInfo: FileInfo;
    uid_target: string;
    uid: string;
    url: string;

    constructor(
        private router: Router,
        private route: ActivatedRoute,
        private freeHubApiService : FreehubApiService,
        public  af: AngularFire,
    ){ }

    ngOnInit() {
        this.route.params.forEach((params: Params) => {
            this.uid_target = params['uid'];
        });
        this.af.auth.subscribe(auth => {
            if( auth) {
                this.uid = auth.uid;
            }
        });
    }

    navigate(){
        this.router.navigate(['/file-system', this.uid_target, btoa( this.fileInfo.path)]);
    }

    isStreamable(){
        return (
            this.fileInfo.fileInfo.mimetype === 'video/ogg' ||
            this.fileInfo.fileInfo.mimetype === 'video/mp4' ||
            this.fileInfo.fileInfo.mimetype === 'video/webm'
        );
    }

    isPlayable(){
        return this.fileInfo.fileInfo.mimetype.substr( 0, 5) == 'audio' || this.fileInfo.fileInfo.mimetype.substr( 0, 5) == 'video';
    }

    playInBrowser() {
        this.freeHubApiService.send( 'filesystem', 'share', {
            "path" : this.fileInfo.path
        }).then( shareLink => {
            let link = ['/player', btoa( shareLink.url), btoa( this.fileInfo.fileInfo.mimetype)];
            this.router.navigate(link);
        });
    }

    directDownload( ) {
        console.info('Pas encore implémenté !');
    }

    play(){
        this.freeHubApiService.send( 'filesystem', 'play', {
            "path" : this.fileInfo.path,
            "uid_src" : this.uid_target,
            "uid_dst" : this.uid
        })
    }

}
