import { BrowserModule } from '@angular/platform-browser';
import { NgModule, LOCALE_ID } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AngularFireModule, AuthProviders, AuthMethods } from 'angularfire2';

import { routing }               from "./app.routing";
import { AppComponent  }         from './app.component';
import { AssociationComponent }  from "./association/association.component";
import { AssociationStep1Component } from "./association/association-step1/association-step1.component";
import { AssociationStep2Component } from "./association/association-step2/association-step2.component";
import { AssociationStep3Component } from "./association/association-step3/association-step3.component";
import { DlRssComponent }        from "./dl-rss/dl-rss.component";
import { DownloadComponent }     from "./download/download.component";
import { DownloadItemComponent } from "./download/download-item/download-item.component";
import { FileInfoComponent }     from "./file-system/file-info/file-info.component";
import { FileSystemComponent }   from "./file-system/file-system.component";
import { FreeboxInfoComponent }  from "./home/freebox-info/freebox-info.component";
import { HomeComponent }         from "./home/home.component";
import { MenuHeaderComponent }   from "./menu-header/menu-header.component";
import { PlayerComponent }       from "./player/player.component";
import { UploadComponent } from "./upload/upload.component";
import { SettingsComponent } from "./settings/settings.component";

import { FreehubApiService }     from "./shared/freehub-api.service";

import { OctetToHumanReadablePipe } from "./shared/octet-human-readable.pipe";

export const config = {
  apiKey: "AIzaSyBzQwe1bXEUpOUD_Q3Gm8JzdZn0FtRMtWs",
  authDomain: "freebox-os.firebaseapp.com",
  databaseURL: "https://freebox-os.firebaseio.com",
  storageBucket: "freebox-os.appspot.com"
};

const myFirebaseAuthConfig = {
  provider: AuthProviders.Google,
  method: AuthMethods.Popup
};

@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        HttpModule,
        routing,
        AngularFireModule.initializeApp( config, myFirebaseAuthConfig)
    ],
    declarations: [
        AppComponent,
        AssociationComponent,
        AssociationStep1Component,
        AssociationStep2Component,
        AssociationStep3Component,
        DlRssComponent,
        DownloadComponent,
        DownloadItemComponent,
        FileInfoComponent,
        FileSystemComponent,
        FreeboxInfoComponent,
        HomeComponent,
        MenuHeaderComponent,
        PlayerComponent,
        UploadComponent,
        SettingsComponent,
        // Pipes
        OctetToHumanReadablePipe,
    ],
    providers: [
        { provide: LOCALE_ID, useValue: "fr-FR" },
        FreehubApiService,
    ],
    bootstrap: [
        AppComponent
    ],
})

export class AppModule {
}
