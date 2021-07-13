# Play Lumen Dice

This is only game dice, under format API.

## Deploy (local)

- `git clone`;
- `cp .env.example .env`;
- Set string(32) to `APP_KEY`;
- `docker-compose up`;

## Execute Test Unit

Execute command by docker:

All test:
- `docker exec play-lumen-dice-api vendor/bin/phpunit`;

Or one test
- `docker exec play-lumen-dice-api vendor/bin/phpunit --bootstrap bootstrap/app.php tests/DiceTest.php`;

## Request to play

Request:

- `http://0.0.0.0/api/play`

Method:
- GET

Parameters:
- quantity `[1-5]`
- face `[4,6,8,10,12,13,14,15,16,17,18,19,20]`

Description:

- `Quantity` is not required and default value is `1`.
- `Face` is not required and default value is `6`.

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
