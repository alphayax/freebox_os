import { Component } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {MenuHeaderComponent} from "./menu-header.component";

@Component({
  selector: 'my-app',
  template: `    
  <menu-header></menu-header>    
  <router-outlet></router-outlet>
    `,
})

export class AppComponent {

}

