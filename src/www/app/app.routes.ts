import { provideRouter, RouterConfig }  from '@angular/router';
import { DownloadComponent } from './download.component';
import {FileSystemComponent} from "./file-system.component";

const routes: RouterConfig = [
  {
    path: 'download',
    component: DownloadComponent
  },
  {
    path: 'file-system',
    component: FileSystemComponent
  }
];

export const appRouterProviders = [
  provideRouter(routes)
];
