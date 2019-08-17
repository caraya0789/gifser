## How to install:

1. Clone the repository
2. Run composer install
3. Generate your homestead config file
4. Adjust your enviroment (.env) settings
5. vagrant up
6. vagrant ssh
7. Run the migrations and seed

## AUTHENTICATION
A default user is provided, but Registration is open

Email: cristian0789@gmail.com
Passw: admin123

## API
A default app key for Giphy is provided in the .env.example, feel free to change it for your own.

The Giphy API is implemented in app/Library/GiphyAPI.php class, it exposes 2 methods

1. search( $query )
2. get_by_ids( $ids, $size = '' )

$ids should be an array of 1 or more ids
$size can be empty or 'full' for single views

## ROUTES AND VIEWS

Authentication routes and views are Laravel Standard Authentication.

Application Routes
1. / => Search
2. /favorites => User Favorites gifs
3. /history => User Search History
4. /view/{id} => Single gif view

Helper Routes
1. /remove_favorites => Allow user to remove a favorite from the Favorites view
2. /view => Redirects to search in case the id is missing
3. /{id} => Redirects to single view, This is for sharable urls

API Routes
We are not using the laravel default api middleware since it's stateless
1. /api/search => provides search results and pagination based on 'q' and 'p' parametters 
2. /api/favorite => toggles a user favorite base on the 'id' param

Views
1. home.blade.php => This displays the search form and other Vue html for the results
2. favorites.blade.php => This displays the user favorites gifs
3. history.blade.php => This displays the user search history in a table
4. single.blade.php => This displays the gif single view

## CONTROLLERS
All routes are controlled by the HomeController

## MODELS
There are only 3 models
1. User => Contains all the logic related to the User and its data
2. Favorite => Represents a single user favorite gif
    Contains only the related user id and the gif id
3. Search => Represents a single user search
    Contains only the related user id and the query

## SEARCHING
Search is controlled by the vue app in resources/js/app.js, it interacts with the /api/search endpoint to provide search results

## SEARCH HISTORY
Everytime a user searches, a new entry is added to the searches table, this step is skip on pagination request that use the same endpoint. This is controlled in the /api/search endpoint.

## SAVE FAVORITES
The search results template shows a heart that can be clicked to add or remove Favorites for the user, on click, the vue app issues a request to /api/favorite with the gif id, if the id is already a favorite then it's removed, else, it will be added.

User can see and remove favorites from the /favorites url as well.

## SHARING
A user can click a search result image to go to the gif single view, from there the user can share a shorter link.

Regarding the url shorttener algorithm, it was no possible to implement, since all this systems work based on a numeric index, which we don't have in the current Giphy API, so we are using the already hashed gif id as is. We tried a couple of shorttener algorithms but we always end up with a bigger string, which was not the desired result.

## TESTING
1. Create a .env.testing with your testing settings, Recommended to use a different database
2. vagrant ssh and run the migrations for the testing env, php artisan migrate --seed --env=testing
3. vendor/bin/phpunit
