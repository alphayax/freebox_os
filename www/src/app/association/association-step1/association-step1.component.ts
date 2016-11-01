import {Component, EventEmitter, Input} from '@angular/core';
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../../shared/freehub-api.service";
import {Output} from "@angular/core/src/metadata/directives";
import {FreeboxAssociation} from "../../shared/freebox-association";

@Component({
    selector: 'association-step1',
    templateUrl: 'association-step1.component.html',
})

export class AssociationStep1Component {

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

    saveAssociation(){

        /// Check parameters
        if( ! this.uid){
            console.error( 'User is not logged in');
        }
        if( ! this.freeboxAssociation.api_domain || ! this.freeboxAssociation.https_port){
            console.error( 'Erreur : Tous les champs ne sont pas renseignes.');
            return;
        }

        this.freeHubApiService.send( 'freebox', 'ping', {
            "uid"   : this.uid,
            "assoc" : this.freeboxAssociation,
        })
        .then( freebox => {
            console.log( freebox);
            console.log( "Association réussie");
            this.onStepValidation.emit( this.freeboxAssociation);
        });
    }

}
