import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule }   from '@angular/forms';
import { HttpModule }    from '@angular/http';

import { routing } from './app.routing';
import {AppComponent} from "./app.component";
import {DownloadComponent} from "./download/download.component";
import {AssociationComponent} from "./association/association.component";
import {FileSystemComponent} from "./file-system/file-system.component";
import {DownloadItemComponent} from "./download/download-item/download-item.component";
import {MenuHeaderComponent} from "./menu-header.component";
import {FileInfoComponent} from "./file-system/file-info/file-info.component";
import {HomeComponent} from "./home/home.component";
import {DlRssComponent} from "./dl-rss/dl-rss.component";

import {FileSystemService} from "./file-system/file-system.service";

@NgModule ({
    imports: [
        BrowserModule,
        FormsModule,
        HttpModule,
        routing
    ],
    declarations: [
        AppComponent,
        HomeComponent,
        DownloadComponent,
        DownloadItemComponent,
        AssociationComponent,
        FileSystemComponent,
        MenuHeaderComponent,
        FileInfoComponent,
        DlRssComponent,
    ],
    providers: [
        FileSystemService,

    ],
    bootstrap: [
        AppComponent
    ],
})

export class AppModule {
}
