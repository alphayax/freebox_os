import {Component} from '@angular/core';
import {AngularFire, AuthMethods, AuthProviders} from 'angularfire2';

@Component({
    selector: 'app-root',
    templateUrl: 'app.component.html',
    styles: [
        '@import url("https://bootswatch.com/darkly/bootstrap.min.css");',
        '@import url("https://bootswatch.com/assets/css/custom.min.css");',
    ],
})

export class AppComponent {

    constructor(
        public af: AngularFire
    ){ }

    login() {
        this.af.auth.login({
            provider: AuthProviders.Google,
            method: AuthMethods.Popup,
        });
    }

}
