import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {StoreModule} from "@ngrx/store";
import {metaReducer} from "./common/index";
import {CharacterSelectComponent} from "./scenes/characterSelect/characterSelect.component";

@NgModule({
    declarations: [
        AppComponent,
        CharacterSelectComponent
    ],
    imports: [
        BrowserModule,
        StoreModule.provideStore(metaReducer),
    ],
    providers: [],
    bootstrap: [AppComponent]
})
export class AppModule {
}
