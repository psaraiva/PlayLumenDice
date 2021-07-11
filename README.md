# Play Lumen Dice

This is only game dice, under format API.

## Deploy (local)

- `git clone`;
- `cp .env.example .env`;
- Add string(32) to `APP_KEY`;
- `docker-compose up`;

## Execute Test Unit

Execute command by docker:

- `docker exec play-lumen-dice-api vendor/bin/phpunit`;

## Request to play

Request to:

- *`http://0.0.0.0/api/play?quantity=1&face=6`

Where:
- Quantity `[1-5]`;
- **Face `[4,6,8,10,12,13,14,15,16,17,18,19,20]`;

*Check your host and port.

**Face is not required and default value is `6`.

## Developement
Today the API contains only single feature, but,
in the future it may have more interesting features...
