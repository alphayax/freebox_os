import {Component} from '@angular/core';
import {AssociationService} from "./association.service";

@Component({
    selector: 'association',
    templateUrl: 'association.component.html',
    providers: [AssociationService]
})

export class AssociationComponent {

    app_token: string;
    track_id: number;
    api_domain: string;
    https_port: number;

    error: any;

    constructor(
        private associationService : AssociationService
    ){ }

    addFreebox(){
        console.log( "component : addFreebox");
        let association = {
            "app_token"  : this.app_token,
            "track_id"   : this.track_id,
            "api_domain" : this.api_domain,
            "https_port" : this.https_port
        };

        /// Check parameters
        if( ! association.api_domain || ! association.track_id || ! association.https_port || ! association.app_token){
            console.error( 'Erreur : Tous les champs ne sont pas renseignes.');
            return;
        }

        this.associationService.addFreebox( association)
            .then(freebox => {
                console.log( freebox);
            })
            .catch(error => this.error = error);
    }
}

