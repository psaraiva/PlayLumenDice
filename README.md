# Play Lumen Dice

This is only game dice, under format API.

## Deploy (local)

- `git clone`;
- `cp .env.example .env`;
- Set string(32) to `APP_KEY`;
- `docker-compose --env-file ./src/.env up -d`;

## Execute [PHP Unit](https://phpunit.de/)

Execute command by docker:

- `docker exec play-lumen-dice-api vendor/bin/phpunit` (default)
- `docker exec play-lumen-dice-api vendor/bin/phpunit --bootstrap bootstrap/app.php tests/class/DiceTest.php` (by file - class)

*_Check config in `phpunit.xml`._

## Execute [Psalm](https://psalm.dev/)

Execute command by docker:

- `docker exec play-lumen-dice-api vendor/bin/psalm` (default)
- `docker exec play-lumen-dice-api vendor/bin/psalm app/Http/Controllers/DiceController.php` (by file)
- `docker exec play-lumen-dice-api vendor/bin/psalm app/Http/Controllers/` (by folder)

*_Check config in `psalm.xml`._

## Execute [PHP Insights](https://phpinsights.com/)

Execute command by docker:

- `docker exec play-lumen-dice-api vendor/bin/phpinsights` (default)
- `docker exec play-lumen-dice-api vendor/bin/phpinsights analyse app/Http/Controllers/DiceController.php` (by file)
- `docker exec play-lumen-dice-api vendor/bin/phpinsights analyse app/Http/Controllers/` (by folder)
- `docker exec play-lumen-dice-api vendor/bin/phpinsights analyse --format=json > DiceClass.json app/Models/Dice.php` (save json)

## Collection by [Postman](https://www.postman.com/)
- Version: `v2.1.0`
- File: `app/doc/postman/Play-Lumen-Dice.postman_collection.json`

## Request to play

Request:

- `http://0.0.0.0/api/play`

Method:
- `GET`

Parameters:
- Quantity `[1-5]`
- Face `[4,6,8,10,12,13,14,15,16,17,18,19,20]`

Description:

- `Face` is not required and default value is `6`.
- `Quantity` is not required and default value is `1`.

Response:
```
{
    "dice": [
        2
    ]
}
```

## Developement
Today the API contains only single feature, but,
in the future it may have more interesting features...
