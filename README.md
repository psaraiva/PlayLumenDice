# Play Lumen Dice

This is game of dice, by API.

## Start
- `git clone`
- `cd PlayLumenDice`
- `cp ./src/.env.example ./src/.env`
- Set *string(32)* to **APP_KEY** in **src/.env** file (Linux: `echo 'my super password' | md5sum`)

## Start + Docker Compose
After the start `step`:
- `docker compose --env-file ./src/.env build app`
- `docker compose up -d`
- `docker compose ps`
- `docker compose exec app ls -l`
- `docker compose exec app rm -rf vendor composer.lock`
- `docker compose exec app composer install`

## Start + Docker PHP local server
After the start `step`:
```Docker
docker build -f ./docker/php-local/Dockerfile -t play-lumen-dice-local-server .

docker run \
  -p 8000:8000 \
  --name play-lumen-dice-local-server \
  -v /root/projects/PlayLumenDice/src:/playlumendice \
  play-lumen-dice-local-server
```

## Start + Docker PHP local server + Xdebug
After the start `step`:
```Docker
docker build -f ./docker/php-xdebug/Dockerfile -t play-lumen-dice-local-server-xdebug .

docker run \
  -p 8000:8000 \
  --name play-lumen-dice-local-server-x \
  -v /root/projects/PlayLumenDice/src:/playlumendice \
  -v /root/projects/PlayLumenDice/docker/php-xdebug/docker-php-ext-xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
  -v /root/projects/PlayLumenDice/docker/php-xdebug/local.ini:/usr/local/etc/php/conf.d/local.ini \
  play-lumen-dice-local-server-xdebug
```
Use `.vscode/launch.json` to configuration listener Xdebug.

-- -
## [PHP Pest](https://pestphp.com/)
Execute command by docker:
- `docker exec -it play-lumen-dice-api ./vendor/bin/pest` (default)
- `docker exec -it play-lumen-dice-api ./vendor/bin/pest --group resource-json` (by group)
- `docker exec -it play-lumen-dice-api ./vendor/bin/pest --coverage` (by coverage)

Groups
- unit
- model
- model-dice
- request
- resource-json
- helper
- helper-mime-type

*_Check config in `phpunit.xml`. e `Pest.php`._

-- -
## [Psalm](https://psalm.dev/)

Execute command by docker:
- `docker exec play-lumen-dice-api vendor/bin/psalm` (default)
- `docker exec play-lumen-dice-api vendor/bin/psalm app/Http/Controllers/DiceController.php` (by file)
- `docker exec play-lumen-dice-api vendor/bin/psalm app/Http/Controllers/` (by folder)

*_Check config in `psalm.xml`._

-- -
## [PHP Insights](https://phpinsights.com/)

Execute command by docker:
- `docker exec play-lumen-dice-api vendor/bin/phpinsights` (default)
- `docker exec play-lumen-dice-api vendor/bin/phpinsights analyse app/Http/Controllers/DiceController.php` (by file)
- `docker exec play-lumen-dice-api vendor/bin/phpinsights analyse app/Http/Controllers/` (by folder)
- `docker exec play-lumen-dice-api vendor/bin/phpinsights analyse --format=json > DiceClass.json app/Models/Dice.php` (save json)

-- -
## Collection by [Postman](https://www.postman.com/)
- Version: `v2.1.0`
- File: `app/doc/postman/Play-Lumen-Dice.postman_collection.json`

-- -
## Request to play

Request:
- `http://0.0.0.0/api/dice/play`

Method:
- `GET`

Header:
- `Accept`: `[application/json,image/png]`

Parameters:
- Quantity `[1-5]`
- Face `[4,6,8,10,12,13,14,15,16,17,18,19,20]`

Description:
- `Face` is not required and default value is `6`.
- `Quantity` is not required and default value is `1`.

Response Json to quantity `3`, face `6`:
```
{
    "dice": [
        2,
        4,
        1
    ]
}
```

Response Image PNG to quantity `3`, face `6`:

![alt text](docs/assets/3_dice_6_faces.png)

## Enable to use with REST Client - see request folder
- Name: REST Client
- Id: humao.rest-client
- Description: REST Client for Visual Studio Code
- Version: 0.25.1
- Publisher: Huachao Mao
- VS Marketplace Link: https://marketplace.visualstudio.com/items?itemName=humao.rest-client

## Static-X
- PHP: 8.0.30
- Xdebug: 3.x
- Nginx: 1.21.6
- Docker Compose: 2
- Postman: v2.1.0
- Visual Code plugin REST Client: 0.25.1
