import { Component } from '@angular/core';
import {ROUTER_DIRECTIVES} from "@angular/router";
import {MenuHeaderComponent} from "./menu-header.component";

@Component({
  selector: 'my-app',
  template: `    
  <menu-header></menu-header>    
  <router-outlet></router-outlet>
    `,
  directives: [
      ROUTER_DIRECTIVES,
      MenuHeaderComponent,
  ],

})

export class AppComponent {

}

