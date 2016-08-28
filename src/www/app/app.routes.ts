import { provideRouter, RouterConfig }  from '@angular/router';
import { DownloadComponent } from './download/download.component';
import { FileSystemComponent } from "./file-system/file-system.component";
import { HomeComponent } from "./home/home.component";
import { AssociationComponent } from "./association/association.component";

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
    path: 'association',
    component: AssociationComponent
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
