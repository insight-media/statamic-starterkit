# New project workflow

## Setting up the environment

* File > Rename project
* Edit Homestead.yaml
* Add DNS mapping to host file
* Run following commands on the host machine:
  * yarn install
  * php artisan insightmedia:configure:starterkit
  * vagrant up
  * vagrant ssh
* Edit .env

## Deployment

* Edit deploy.php
* Push to origin

### Upload .env.*branch* to host
dep upload-env

### Deploy
dep deploy

### Download public storage folder
dep download-public-storage
