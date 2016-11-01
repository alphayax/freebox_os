import {Component, OnInit, EventEmitter} from '@angular/core';
import {AngularFire} from "angularfire2";
import {FreehubApiService} from "../../shared/freehub-api.service";
import {Output, Input} from "@angular/core/src/metadata/directives";
import {FreeboxAssociation} from "../../shared/freebox-association";

@Component({
    selector: 'association-step2',
    templateUrl: 'association-step2.component.html',
})

export class AssociationStep2Component implements OnInit {

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


    saveToken(){

        /// Check parameters
        if( ! this.uid){
            console.error( 'User is not logged in');
        }
        if( ! this.freeboxAssociation.app_token){
            console.error( 'Erreur : Tous les champs ne sont pas renseignes.');
            return;
        }

        // Clean token
        this.freeboxAssociation.app_token = this.freeboxAssociation.app_token.replace('\\/', '/');


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
