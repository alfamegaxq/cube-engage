Cube Engage
=============

The full stack rover
 
### Project setup
- add to your `/etc/hosts` file `127.0.0.1 challenge.dev`
- `composer install --ignore-platform-reqs`
- `docker-compose build` (optional to rebuild containers)
- `docker-compose up`
- wait for text: `angular_1  | webpack: Compiled successfully.`
- connect to php container `docker exec -it challenge_php bash` and launch command:
`php bin/console doctrine:schema:update --force`
- if previous step provided some errors, try deleting `.docker_data` fodler
- open browser `0.0.0.0:4200`

### Tests

- Connect to php container: `docker exec -it challenge_php bash`
- `php vendor/bin/phpunit`
- `php vendor/bin/behat`

### Technologies used

- symfony 3.3
- behat + mink
- phpunit
- mysql
- angular 4
- Redux

### Gameplay

#### First steps

- You begin by having two options. 1 - login typing your previous username, 2 - picking a color and pressing `Continue` button
- By choosing a color then you're asked to type your name and press `Continue`
- After that you'll join you'll join your home screen
- you can go exploring by pressing `Explore` button or `Level up` if you have enough skill points

#### Deep into game

- By pressing `explore` you'll get a map to complete.
- **The goal** is to destroy half of the displayed tiles.
- map size depends on the level. If you are `level 6`, you'll see a map, consisting of 6x6 tiles
- Each tile has health equal to `rand(1, your level * 2)`
- after clicking on a tile, you'll do damage equal to your attack points.
- If tile as `0` health points, it will become red. If it's still `>0` hp, it will hit you back with it's remaining hp
- You'll get `1000xp` from destroying tile, so it's a lucky chance for weaker tiles to appear
- Each click on tile will give you `1000 points`

#### After

- After leveling up, you are rewarded by `1 skill point`. You can spend it in `Level up` section
- You can increase your attack points or score multiplier.
- After dying (when your hp reaches 0), you'll be redirected to end game screen with your score and top 10 scorings.
- Hint: at end of the game your character will be deleted, so you can create a new one with the same name

### Architecture

- Frontend SPA is based on angular components and services that communicate with Symfony API. There's a api token
saved in cookies for authentication.
- Frontend state is saved in Redux store and managed by reducers. Store is saved in browser local storage and 
loaded after each refresh.
- Backend has two entities `Player` - to store active players data, and `Score` - to store all score history
- There are events emited `LevelUpEvent`, `MapALlTilesDestroyedEvent`, `MapTileDestroyedEvent`

### Redux store

Actions are in `frontend/app/common/actions` directory

To dispatch an action, so reducer could manage it:
`this.store.dispatch(new actions.SelectCharacterColor(type));`

make sure that store is injected in your component.

To subscribe to state:
```
this.characterSubscription = this.store.select('character').subscribe((state: State) => {
    //...
}
```

**WARNING**

Don't forget to unsubscribe on destroy event

```
    ngOnDestroy(): void {
        this.commonSubscription.unsubscribe();
    }
```

This means component needs to implement `OnInit`

### User Stories

- As a player I want to create a character

When You are on route base route, select a color and press `continue`, then enter your name (min. 3 symbols)
and press continue. When you are redirected to home screen, on the left side you'll se your selected color name
and username

- As a player I want to explore

On home screen there is a button `explore`. By clicking it you'll be moved to a screen with tiles.
What to do there and how to play please read "Gameplay -> Deep into game" readme chapter

- As a player I want to gain experience through fighting

on `explore` screen after clicking few times on a tile until it's red, you'll get xp.
The xp needed for next level is calculated `level^2 * 1000`

- As a player I want to save and resume a game

Application state is saved in local storage after each action. So after refreshing browser store will be loaded.
Player information is stored into database `player` table, so on being in `/` path, you'll have the ability
to type your name and proceed with your game - Api call is made and state is loaded.

- As a player I want to see the top 10 score list so that I could compete with others

At the end of the game, player is presented with his score and top 10 player scores.

### Issues and solutions

**Problem:** on starting the application and visiting 0.0.0.0:4200 screen is blank and console shows error:
`No NgModule metadata found for 'AppModule'`

**Solution:** turn off docker containers, remove `node_modules` from `/frontend` and start `docker-compose up` again

**Problem:** I'm getting error 404

**Solution:** Angular might be still booting up, wait for a few seconds and then refresh your browser

**Problem:** clicking somewhere nothing happens

**Solution:** this might be caused due to bad permissions of cache and logs folder. `chown` and `chmod` it

**Problem:** browser console shows `net::ERR_CONNECTION_REFUSED`

**Solution:** your docker crashed. This shouldn't happen on normal scenario

**Problem:** trying to update schema you can get permission denied for ip xxx.xx.xxx.xxx error

**Solution:** for me helped deleting .docker_data

### TODOs

There are still some minor functionalities missing

- when trying to login by typing username, if the username is wrong, no message is shown
- Design missing, now only basic bootstrap figures are being displayed
- find a better solution for `npm install` in Dockerfile. It takes too long. Maybe add base image to dockerhub
- configure webpack to compile sass
