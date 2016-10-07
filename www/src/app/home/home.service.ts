import {Injectable} from '@angular/core';
import {FreehubApiService} from "../shared/freehub-api.service";



@Injectable()
export class HomeService {

    constructor(
        private freeHubApiService : FreehubApiService,
    ) { }

    getFreeboxInfo( uid){

        return this.freeHubApiService.send( 'config', 'get_freebox', {
            "uid" : uid
        }).then( response => response as string[]);
    }

}
