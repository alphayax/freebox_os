import {Component} from '@angular/core';
import { AngularFire,AuthMethods,AuthProviders } from 'angularfire2';

@Component({
  selector:'app-root',
  templateUrl: 'app.component.html',
  styles : [
      '@import url("https://bootswatch.com/darkly/bootstrap.min.css")',
      '@import url("https://bootswatch.com/assets/css/custom.min.css")',
  ]
})

export class AppComponent{
  imageUrl:string;
  values:Array<any>;
  constructor(public af: AngularFire) {
    let tempArray=[];
    this.af.auth.subscribe(auth =>
    {

      for(let key in auth){
        tempArray.push(auth[key]);
      }
      this.values=tempArray;
    });
  }

  public getData(){
    let values=this.values[3];
    console.log(values);
    console.log(values.photoURL);
    this.imageUrl=values.photoURL;
  }

  login() {
    this.af.auth.login({
      provider: AuthProviders.Google,
      method: AuthMethods.Popup,
    });
  }
  logout(){
    this.imageUrl='';
    this.af.auth.logout();
  }

}
