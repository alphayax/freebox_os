import { Component } from '@angular/core';

export class NavElem {
  name: string;
  service: string;
}

const NAV_ELEMS : NavElem[] = [
  { service: 'home', name: 'Accueil' },
  { service: 'file-system', name: 'Fichiers' },
  { service: 'download', name: 'Mes téléchargements' },
];

@Component({
  selector: 'menu-header',
  templateUrl : 'menu-header.component.html',
})

export class MenuHeaderComponent {
  navElements = NAV_ELEMS;
}

