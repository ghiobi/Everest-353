# Project Undecided

## How to setup environment
There are a few steps to setup the repo on the localhost.
1. Run composer: `composer install`
2. Setup environment file (.env): `composer run post-root-package-install`
3. Generator salt: `php artisan key:generate`
4. Run server: `php artisan serve`