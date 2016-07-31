import { provideRouter, RouterConfig }  from '@angular/router';
import { DownloadComponent } from './download.component';
import {FileSystemComponent} from "./file-system.component";
import {HomeComponent} from "./home/home.component";

const routes: RouterConfig = [
  {
    path: 'download',
    component: DownloadComponent
  },
  {
    path: 'file-system',
    component: FileSystemComponent
  },
  {
    path: 'home',
    component: HomeComponent
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full'
  }
];

export const appRouterProviders = [
  provideRouter(routes)
];
