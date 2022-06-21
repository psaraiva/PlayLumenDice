# Play Lumen Dice

This is game of dice, under format API.

## Deploy (local)

- `git clone`;
- `cd PlayLumenDice`
- `cp ./src/.env.example ./src/.env`;
- `docker-compose --env-file ./src/.env up -d`;
- `docker exec -it play-lumen-dice-api php /usr/bin/composer install`;
- Set *string(32)* to **APP_KEY** in **.env** file; (Linux: `echo -n 'my super password' | md5sum`)

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

## Developement
Today the API contains only single feature, but,
in the future it may have more interesting features...
