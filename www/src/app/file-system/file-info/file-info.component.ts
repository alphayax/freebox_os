import {Component, Input, OnInit} from '@angular/core';
import { FileInfo } from "../file-info";
import { Router, Params, ActivatedRoute } from "@angular/router";
import { FreehubApiService} from "../../shared/freehub-api.service";


@Component({
    selector: 'file-info',
    templateUrl: 'file-info.component.html',
})

export class FileInfoComponent implements OnInit {

    @Input()
    fileInfo: FileInfo;
    uid: string;
    url: string;

    constructor(
        private router: Router,
        private route: ActivatedRoute,
        private freeHubApiService : FreehubApiService,
    ){ }

    ngOnInit() {
        this.route.params.forEach((params: Params) => {
            this.uid = params['uid'];
        });
    }

    navigate(){
        this.router.navigate(['/file-system', this.uid, btoa( this.fileInfo.path)]);
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
            "path" : this.fileInfo.path
        })
    }

}
