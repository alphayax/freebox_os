
import {Injectable} from '@angular/core';
import {FreehubApiService} from "./freehub-api.service";


@Injectable()
export class PosterService {

    public static cache : {};

    constructor(
        private freeHubApiService : FreehubApiService,
    ){ }

    getImage( fileName : string){

        if( undefined === PosterService.cache){
            PosterService.cache = {};
        }

        if( PosterService.cache[fileName]){
            return Promise.resolve( PosterService.cache[fileName]);
        }

        return this.freeHubApiService.send( 'poster', 'get_image', {
            "file_name" : fileName
        }).then( response => {
            PosterService.cache[fileName] = response;
            return response;
        });
    }

}

