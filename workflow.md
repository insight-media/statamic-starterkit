# New project workflow

## Setting up the environment

* File > Rename project
* Edit .env
* Edit Homestead.yaml
* Add DNS mapping to host file
* Edit after.sh
* Run vagrant_up.sh
* Run following commands in newly made Vagrant machine:
    * composer install
    * php artisan migrate
    * php artisan db:seed
    * sudo npm install --force --verbose --no-bin-links
    
## Initial steps for configuring Webwizard website

* Set languages in config/translatable.php
* Complete the 'site instellingen' page
* Run command in Vagrant machine: npm run watch

## Deployment

* Copy public storage files to remote:
scp -r storage/* username@sub.webhosting.be:~/checkout/master/shared/storage

