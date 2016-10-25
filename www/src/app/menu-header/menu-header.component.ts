import {Component} from '@angular/core';
import {AngularFire} from "angularfire2";

export class NavElem {
    name: string;
    service: string;
    icon: string;
}

const NAV_ELEMS: NavElem[] = [
    { service: 'home', name: 'Accueil', icon: 'home' },
    { service: 'download', name: 'Mes téléchargements', icon: 'save' },
    { service: 'upload', name: 'Mes partages', icon: 'open' },
];

@Component({
    selector: 'menu-header',
    templateUrl: 'menu-header.component.html',
})

export class MenuHeaderComponent {

    navElements = NAV_ELEMS;

    constructor(
        public  af: AngularFire,
    ){}

    logout() {
        this.af.auth.logout();
    }

}

