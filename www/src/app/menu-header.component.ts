import { Component } from '@angular/core';

export class NavElem {
  name: string;
  service: string;
}

const NAV_ELEMS : NavElem[] = [
  { service: 'home', name: 'Accueil' },
  { service: 'file-system', name: 'Système de fichiers' },
  { service: 'download', name: 'Téléchargements' },
];

@Component({
  selector: 'menu-header',
  templateUrl : 'menu-header.component.html',
})

export class MenuHeaderComponent {
  navElements = NAV_ELEMS;
}

