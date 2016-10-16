import { Component } from '@angular/core';

export class NavElem {
  name: string;
  service: string;
  icon: string;
}

const NAV_ELEMS : NavElem[] = [
  { service: 'home', name: 'Accueil', icon: 'home' },
  { service: 'download', name: 'Mes téléchargements', icon: 'download-alt' },
];

@Component({
  selector: 'menu-header',
  templateUrl : 'menu-header.component.html',
})

export class MenuHeaderComponent {
  navElements = NAV_ELEMS;
}

