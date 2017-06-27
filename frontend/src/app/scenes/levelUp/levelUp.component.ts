import {Component, OnInit} from '@angular/core';
import {Stats} from "../../common/entities/stats";
import {Store} from "@ngrx/store";
import {State} from "../../common/reducers/character.reducer";
import * as fromRoot from './../../common/index';
import {CharacterService} from "../../character/character.service";
import * as actions from './../../common/actions/character.actions';

@Component({
    selector: 'scene-levelUp',
    templateUrl: './levelUp.component.html',
    styleUrls: ['./levelUp.component.css'],
    providers: [CharacterService]
})
export class LevelUpComponent implements OnInit {

    stats: Stats;
    private characterSubscription;

    constructor(private store: Store<fromRoot.AppState>, private characterService: CharacterService) {
    }

    ngOnInit(): void {
        this.characterSubscription = this.store.select('character').subscribe((state: State) => {
            this.stats = state.stats;
        });
    }

    increaseAtack() {
        this.characterService.increaseAttack().then((stats: Stats) => {
            this.store.dispatch(new actions.SetCharacterStatus(stats));
        });
    }

    increaseMultiplier() {
        this.characterService.increaseMultiplier().then((stats: Stats) => {
            this.store.dispatch(new actions.SetCharacterStatus(stats));
        });
    }

    ngOnDestroy(): void {
        this.characterSubscription.unsubscribe();
    }
}
