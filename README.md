# AiDevs 2

## Quick start

1. Create file `.env.local`, with proper api keys (based on `.env` file)
2. Start docker
```
docker compose up -d
```
3. Enter the container and run command
```
docker exec -it aidevs2-php-1 /bin/bash
composer install
```
4. Get list of commands
```
bin/console
```
