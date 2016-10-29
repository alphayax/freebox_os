import { ModuleWithProviders }  from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { DownloadComponent } from './download/download.component';
import { FileSystemComponent } from "./file-system/file-system.component";
import { HomeComponent } from "./home/home.component";
import { AssociationComponent } from "./association/association.component";
import { DlRssComponent } from "./dl-rss/dl-rss.component";
import {PlayerComponent} from "./player/player.component";
import {UploadComponent} from "./upload/upload.component";
import {SettingsComponent} from "./settings/settings.component";

const appRoutes: Routes = [
  {
    path: 'download',
    component: DownloadComponent
  },
  {
    path: 'file-system/:uid/:path',
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
    path: 'dl-rss',
    component: DlRssComponent
  },
  {
    path: 'player/:url/:mime',
    component: PlayerComponent
  },
  {
    path: 'upload',
    component: UploadComponent
  },
  {
    path: 'settings',
    component: SettingsComponent
  },
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full'
  }
];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);
