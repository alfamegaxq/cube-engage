import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {StoreModule} from "@ngrx/store";
import {metaReducer} from "./common/index";
import {CharacterSelectComponent} from "./scenes/characterSelect/characterSelect.component";
import {AppRoutingModule} from "app/app.routing.module";
import {NameSelectComponent} from "./scenes/nameSelect/nameSelect.component";
import {HttpModule} from "@angular/http";
import {HomeComponent} from "./scenes/home/home.component";
import {StatsComponent} from "./character/stats/stats.component";
import {WelcomeComponent} from "./scenes/home/welcome/welcome.component";
import {MapComponent as MapSceneComponent} from "./scenes/map/map.component";
import {MapComponent} from "./map/map.component";
import {SuccessComponent} from "./scenes/success/success.component";
import {LevelUpComponent} from "./scenes/levelUp/levelUp.component";
import {EndGameComponent} from "./scenes/endGame/endGame.component";
import {LoginComponent} from "./scenes/login/login.component";
import {ScoreListComponent} from "./scoreList/ScoreList.component";

@NgModule({
    declarations: [
        AppComponent,
        CharacterSelectComponent,
        NameSelectComponent,
        HomeComponent,
        StatsComponent,
        WelcomeComponent,
        MapSceneComponent,
        MapComponent,
        SuccessComponent,
        LevelUpComponent,
        EndGameComponent,
        LoginComponent,
        ScoreListComponent
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
