# Laravel To-Do App

This is a simple ToDo app with Laravel 6.

## Prerequisites

* Composer
* Laravel 6
* Vue
* Vuex
* npm


## Installation

Clone the repository-
```
git clone https://github.com/milon521/laravel-todo.git
```

Then cd into the folder with this command-
```
cd laravel-todo
```

Then do a composer install
```
composer install
```

Then do a npm install
```
npm install
```

Then create a environment file using this command-
```
cp .env.example .env
```

Then edit `.env` file with appropriate credential for your database server. Just edit these two parameter(`DB_USERNAME`, `DB_PASSWORD`).

Then create a database and then do a database migration using this command-
```
php artisan migrate
```

To build project assets using this command-
```
npm run dev
```

At last generate application key, which will be used for password hashing, session and cookie encryption etc.
```
php artisan key:generate
```

## Run server

Run server using this command-
```
php artisan serve
```

Then go to `http://localhost:8000` from your browser and see the app.


## Built With

* [Laravel](https://laravel.com/) - Beautiful Php framework
* [Vue](https://vuejs.org/) - A Great reactive Js framework
* [Vuex](https://vuejs.org/) - Vuejs state management made simple
* [Bootstrap](https://getbootstrap.com) - A beautiful Css framework
* [Axios](https://vuejs.org/) - A Js library to handle ajax requests easily
