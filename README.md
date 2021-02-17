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

Run the migrations

```sh
php artisan migrate
```
