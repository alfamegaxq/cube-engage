import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {StoreModule} from "@ngrx/store";
import {metaReducer} from "./common/index";
import {CharacterSelectComponent} from "./scenes/characterSelect/characterSelect.component";
import {AppRoutingModule} from "app/app.routing.module";
import {NameSelectComponent} from "./scenes/nameSelect/nameSelect.component";
import {HttpModule} from "@angular/http";

@NgModule({
    declarations: [
        AppComponent,
        CharacterSelectComponent,
        NameSelectComponent
    ],
    imports: [
        BrowserModule,
        StoreModule.provideStore(metaReducer),
        AppRoutingModule,
        HttpModule
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
