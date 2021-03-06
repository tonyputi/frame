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
npm install
```

Run the migrations/seeds

```sh
touch database/database.sqlite
php artisan migrate:refresh --seed
```

Create `/etc/sudoers/frame`

```
www-data ALL=(ALL:ALL) NOPASSWD: /usr/sbin/nginx -t
www-data ALL=(ALL:ALL) NOPASSWD: /usr/sbin/nginx -s reload
```

## Quick start

- touch database/database.sqlite
- php artisan migrate --seed
- php artisan serve

## Guidelines

- `master` is representing the stable branch;
- `develop` is representing the develop branch;
- always create a branch from `develop`;

## Known issue

1. Pagination is not resetting to page 0 while searching
2. Modal is removing scroolbar
3. when flush db nginx config command is not flushing file as well

## TODO

1. make use of laravel flash session in order to show jetstram alert on success
2. create a preview of nginx configuration
3. autorefresh both game providers and booking index
4. rename game_providers to location and create proper model make use of tags
5. set the cron to work by minutes instead of 5 minutes steps
6. finish the select jetstream component
7. improve pagination with ...
8. review command name
9. add videoslots style
10. create time calendar select component (hard)
11. add dashboard with queue provider lists