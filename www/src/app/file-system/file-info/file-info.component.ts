import { Component, Input } from '@angular/core';
import { FileInfo } from "../file-info";
import { Router} from "@angular/router";
import { FreehubApiService} from "../../shared/freehub-api.service";


@Component({
    selector: 'file-info',
    templateUrl: 'file-info.component.html',
})

export class FileInfoComponent {

    @Input()
    fileInfo: FileInfo;

    url: string;

    constructor(
        private router: Router,
        private freeHubApiService : FreehubApiService,
    ){ }

    navigate( path : string){
        this.router.navigate(['/file-system', btoa( path)]);
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

    playInBrowser( path : string) {
        this.freeHubApiService.send( 'filesystem', 'share', {
            "path" : path
        }).then( shareLink => {
            let link = ['/player', btoa( shareLink.url), btoa( this.fileInfo.fileInfo.mimetype)];
            this.router.navigate(link);
        });
    }

    directDownload( ) {
        console.info('Pas encore implémenté !');
    }

    play( path){
        this.freeHubApiService.send( 'filesystem', 'play', {
            "path" : path
        })
    }

}
