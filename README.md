![Frame Project](https://www.videoslots.com/diamondbet/images/logo.png)
# Frame Project (Hackathon)

## Casino Provider and environment switcher

With the objective to acquire and redirect a casino provider in any dev environment, the frame project was created to
help developers manage game provider configurations.

Providing a GUI is possible to control the game provider's access by the admin and identify what dev is using each
provider.

## Features
- Avoid SSH access
- Automate Nginx config changes
- Set a time limit to avoid forever redirects to dev machines
- Automatic posting to slack informing the availability of the game provider
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

Create `/etc/sudoers/frame`

```
www-data ALL=(ALL:ALL) NOPASSWD: /usr/sbin/nginx -t
www-data ALL=(ALL:ALL) NOPASSWD: /usr/sbin/nginx -s reload
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

- when flush db nginx config command is not flushing file as well

## TODO

### PHASE 1
- autorefresh both game providers and booking index with setTimeout
- review command name
- add dashboard with bookings organized by provider

### PHASE 2
- create a preview of nginx configuration
- improve pagination with ...
- add videoslots style
- create time calendar select component (hard)
- add dashboard with queue provider lists calendar version
- install opensource implementation of pusher/broadcast
- autorefresh both game providers and booking index through websockets
- add socialiate to proper register players through office365