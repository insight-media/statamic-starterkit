# New project workflow

## Setting up the environment

* File > Rename project
* Edit .env
* Run: php artisan insightmedia:configure:starterkit
* Generate favicons using https://realfavicongenerator.net

## Deployment

* Edit deploy.php
* Push to origin

### Upload .env.*branch* to host
dep upload-env

### Deploy
dep deploy

### Download public storage folder
dep download-public-storage
