#!/bin/bash
echo 'this program suppose you work with mysql installed @127.0.0.1:3306. Say YES to continue'
read yes
if [ "$yes" == YES ]
then
  folder='cashbox'
  chmod -R 755 "$folder"
  touch "$folder"/.env.local
  echo 'Your SQL login : '
  read username
  echo 'Your SQL password : '
  read password
  echo 'database name : '
  read databasename
  setterDb=DATABASE_URL=mysql://$username:$password@127.0.0.1:3306/$databasename
  setterEnd="###< doctrine/doctrine-bundle ###"
  sed '/DATABASE_URL=mysql:///d' "$folder"/.env.local
  sed '/###< doctrine/doctrine-bundle ###/d' "$folder"/.env.local
  echo "$setterDb" >> "$folder"/.env.local
  echo "$setterEnd" >> "$folder"/.env.local
  cd "$folder" || exit
  composer install
  yarn install
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  php bin/console doctrine:fixtures:load
  yarn encore prod
fi
