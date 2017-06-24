import {Routes} from '@angular/router';
import {CharacterSelectComponent} from "./scenes/characterSelect/characterSelect.component";
import {NameSelectComponent} from "./scenes/nameSelect/nameSelect.component";
import {HomeComponent} from "./scenes/home/home.component";


export const appRoutes: Routes = [
    {
        path: '', component: CharacterSelectComponent
    },
    {
        path: 'register', component: NameSelectComponent
    },
    {
        path: 'home', component: HomeComponent
    }
    // {
    //     path: '',
    //     children: [
    //         {
    //             path: '', component: NewestArticleListComponent, outlet: 'left-column'
    //         },
    //         {
    //             path: '', component: HeaderComponent, outlet: 'header'
    //         },
    //     ]
    // },
    // {
    //     path: 'post/:id',
    //     children: [
    //         {
    //             path: '', component: ArticleComponent, outlet: 'left-column'
    //         }
    //     ]
    // },
    // {
    //     path: 'category/:id',
    //     children: [
    //         {
    //             path: '', component: CategoryPageComponent, outlet: 'left-column'
    //         }
    //     ]
    // }
];
