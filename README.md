# Frame Project (Hackathon)

## Casino Provider and environment switcher

With the objective to acquire and redirect a casino provider in any dev environment, the frame project was created to
help developers manage location configurations.

Providing a GUI is possible to control the location's access by the admin and identify what dev is using each
provider.

## Features
- Avoid SSH access
- Automate Nginx config changes
- Set a time limit to avoid forever redirects to dev machines
- Automatic posting to slack informing the availability of the location
- Queue system, allowing casino provider booking


> Basically, Frame propose control and redirect all the casino providers from a single endpoint.
> Version 1.0 expected to apply the solution in only one stage environment with perspective to be easier to move later on to any  level in the next versions

## Installation
Frame requires [PHP](https://www.php.net/downloads.php) v7.3+ and [Node.js](https://nodejs.org/) v8.9+ to run.

Install the dependencies and devDependencies.

```sh
composer install
php artisan key:generate
```

Run the migrations/seeds

```sh
touch database/database.sqlite
php artisan migrate:refresh --seed
```

Serve the application

```sh
php artisan serve
```

Install node development environment (only for developers)
```sh
npm install
npm run watch
```

## Guidelines

- `master` is representing the stable branch;
- `develop` is representing the develop branch;
- always create a branch from `develop` ie `feature/some-new-feature`;

## Known issues

- there is a foreign constraint error while deleting environment;
- create booking from bookings page is not working
- improve pagination with ...

## TODO
- allowing bookings by provider on the heatmap
- add possibility to temporarely disable reserveration/booking of locations
- install opensource implementation of pusher/broadcast
- autorefresh both locations and booking index through websockets (install opensource implementation of pusher/broadcast)
- add socialiate to proper register players through office365
- improve panic button to properly release game providers for emergency
- improve booking date/time selection with suggested next time slots
- create time calendar select component (hard)
- add videoslots style


