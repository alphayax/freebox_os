import {Component, OnInit, EventEmitter} from '@angular/core';
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../../shared/freehub-api.service";
import {Output, Input} from "@angular/core/src/metadata/directives";
import {FreeboxAssociation} from "../../shared/freebox-association";

@Component({
    selector: 'association-step3',
    templateUrl: 'association-step3.component.html',
})

export class AssociationStep3Component implements OnInit {

    uid: string;

    @Input()
    freeboxAssociation : FreeboxAssociation;

    @Output()
    onStepValidation = new EventEmitter<FreeboxAssociation>();

    constructor(
        private freeHubApiService : FreehubApiService,
        public  af: AngularFire,
    ){
        this.af.auth.subscribe( user => {
            this.uid = user ? user.uid : null;
        });
    }

    ngOnInit(){
        this.freeHubApiService.send( 'freebox', 'get_from_uid', {
            "uid"   : this.uid,
        }).then( result => {
            console.log( 'todo : mettre a jour le truc', result);
        })
    }


    validate(){

        this.freeHubApiService.send( 'freebox', 'get_permissions', {
            "uid"   : this.uid,
            "assoc" : this.freeboxAssociation,
        })
        .then( freebox => {
            console.log( freebox);
            console.log( "Association réussie");
            this.onStepValidation.emit( this.freeboxAssociation);
        })
        .catch( error => {
            console.log(error);
        });
    }

}
