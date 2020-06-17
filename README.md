# Trade Show

### Setup
* `PHP >= 7.1.3`

### Installation
1. After cloning run `make setup`.

### Development

#### Libraries (Read about)
* [Laravel 5.8](https://laravel.com/docs/5.8)
* [Bulma](https://bulma.io/documentation/)
* [Vue](http://vuejs.org)
* [Vuex](https://vuex.vuejs.org/)

#### Development guide
1. If you add variables on `.env` **make sure** to update the `.env.example` file.
2. To compile run `yarn hot` or `yarn watch`.
3. After you pull changes especially from `backend` branch just run `make update` to update your app files.

### API
1. Creating `FormRequest` always extend the `BaseRequest` not the `FormRequest` (which is the default).

### Initialize Deployment
1. To used the whitelist ip feature make sure to **update the `.env` file** and set the `APP_ENV` to `production` or `live`.
2. Run `php artisan passport:install` and copy the `client_secret` of the `client ID: 2` and paste value to the `.env` - `PASSPORT_CLIENT_SECRET`.
3. Run `make migrateDeploy` to seed old database data to new database.

### Update Deployment
1. Go to root app folder and run `make deploy`.
