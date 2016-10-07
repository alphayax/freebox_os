import {Injectable} from '@angular/core';
import {FreehubApiService} from "../shared/freehub-api.service";


@Injectable()
export class AssociationService {

    constructor(
      private freeHubApiService : FreehubApiService,
    ) { }

    addFreebox( association){
        return this.freeHubApiService.send( 'config', 'association', association);
    }

}

