import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { AngularFireModule, AuthProviders, AuthMethods } from 'angularfire2';

import { routing }               from "./app.routing";
import { AppComponent  }         from './app.component';
import { AssociationComponent }  from "./association/association.component";
import { DlRssComponent }        from "./dl-rss/dl-rss.component";
import { DownloadComponent }     from "./download/download.component";
import { DownloadItemComponent } from "./download/download-item/download-item.component";
import { FileInfoComponent }     from "./file-system/file-info/file-info.component";
import { FileSystemComponent }   from "./file-system/file-system.component";
import { HomeComponent }         from "./home/home.component";
import { MenuHeaderComponent }   from "./menu-header.component";
import { PlayerComponent }       from "./player/player.component";

import { FileSystemService }     from "./file-system/file-system.service";
import { FreehubApiService }     from "./shared/freehub-api.service";

export const config = {
  apiKey: "AIzaSyBzQwe1bXEUpOUD_Q3Gm8JzdZn0FtRMtWs",
  authDomain: "freebox-os.firebaseapp.com",
  databaseURL: "https://freebox-os.firebaseio.com",
  storageBucket: "freebox-os.appspot.com"
};

const myFirebaseAuthConfig = {
  provider: AuthProviders.Google,
  method: AuthMethods.Redirect
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
        DlRssComponent,
        DownloadComponent,
        DownloadItemComponent,
        FileInfoComponent,
        FileSystemComponent,
        HomeComponent,
        MenuHeaderComponent,
        PlayerComponent,
    ],
    providers: [
        FileSystemService,
        FreehubApiService,
    ],
    bootstrap: [
        AppComponent
    ],
})

export class AppModule {
}
