# New project workflow

## Setting up the environment

* File > Rename project
* Edit .env
* Edit Homestead.yaml
* Add DNS mapping to host file
* Run following commands on the host machine:
  * yarn install
  * php artisan insightmedia:configure:starterkit
  * vagrant up
  * vagrant ssh

## Deployment

* Copy public storage files to remote:
  scp -r storage/* username@sub.webhosting.be:~/checkout/master/shared/storage

