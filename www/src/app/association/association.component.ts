import {Component} from '@angular/core';
import {AssociationService} from "./association.service";
import {AngularFire, FirebaseAuthState} from "angularfire2";

@Component({
    selector: 'association',
    templateUrl: 'association.component.html',
    providers: [AssociationService]
})

export class AssociationComponent {

    user: FirebaseAuthState;
    app_token: string;
    track_id: number;
    api_domain: string;
    https_port: number;

    error: any;

    constructor(
        private associationService : AssociationService,
        public  af: AngularFire,
    ){
        this.af.auth.subscribe(user => {
            if( user) {
                this.user = user;
            } else {
                this.user = null;
            }
        });
    }

    addFreebox(){

        /// Check parameters
        if( ! this.user || ! this.user.uid){
            console.error( 'User is not logged in');
        }
        if( ! this.app_token || ! this.track_id || ! this.api_domain || ! this.https_port){
            console.error( 'Erreur : Tous les champs ne sont pas renseignes.');
            return;
        }

        /// Create association object
        let association = {
            "uid"        : this.user.uid,
            "app_token"  : this.app_token,
            "track_id"   : this.track_id,
            "api_domain" : this.api_domain,
            "https_port" : this.https_port,
        };

        this.associationService.addFreebox( association)
            .then(freebox => {
                console.log( freebox);
                console.log( "Association réussie")
            })
            .catch(error => console.error(error));
    }
}

