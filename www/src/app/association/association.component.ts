import {Component, OnInit} from '@angular/core';
import {AngularFire} from "angularfire2";
import {FreeboxAssociation} from "../shared/freebox-association";
import {FreehubApiService} from "../shared/freehub-api.service";

@Component({
    selector: 'association',
    templateUrl: 'association.component.html',
})

export class AssociationComponent {

    uid: string;

    step: number;

    freeboxAssociation : FreeboxAssociation;
    permissions : any;

    constructor(
        public  af: AngularFire,
        private freeHubApiService : FreehubApiService,
    ){
        this.af.auth.subscribe(user => {
            this.uid = user ? user.uid : null;
            this.checkFreebox();
        });
        this.freeboxAssociation = new FreeboxAssociation;
        this.step = 0;
    }

    checkFreebox() {
        this.freeHubApiService.send( 'freebox', 'get_permissions', {
            "uid"   : this.uid,
        })
        .then( result => {
            console.log( result);
            this.permissions = result;
        })
        .catch( result => {
            this.step = 1;
        })
    }

    onStep1Validation( freeboxAssociation: FreeboxAssociation){
        this.freeboxAssociation = freeboxAssociation;
        this.step = 2;
    }

    onStep2Validation( freeboxAssociation: FreeboxAssociation){
        this.freeboxAssociation = freeboxAssociation;
        this.step = 3;
    }

    onStep3Validation( freeboxAssociation: FreeboxAssociation){
        this.freeboxAssociation = freeboxAssociation;
        this.step = 0;
    }

}

