import {Routes} from '@angular/router';
import {CharacterSelectComponent} from "./scenes/characterSelect/characterSelect.component";
import {NameSelectComponent} from "./scenes/nameSelect/nameSelect.component";
import {HomeComponent} from "./scenes/home/home.component";
import {WelcomeComponent} from "./scenes/home/welcome/welcome.component";


export const appRoutes: Routes = [
    {
        path: '', component: CharacterSelectComponent
    },
    {
        path: 'register', component: NameSelectComponent
    },
    {
        path: 'home',
        children: [
            {path: '', component: HomeComponent, outlet: 'game-stats'},
            {path: '', component: WelcomeComponent, outlet: 'game-screen'}
        ]
    }
];
