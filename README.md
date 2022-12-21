## Cart example project

### Req.:
- Composer
- Docker

### Setup instructions:
- Clone
- Run following commands
  - `cp .env.example .env`
  - `composer install`
  - `./vendor/bin/sail up -d`
  - `./vendor/bin/sail artisan key:generate`
  - `./vendor/bin/sail artisan migrate --seed`
  - `./vendor/bin/sail artisan export:postman` to export postman collection
