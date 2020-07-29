#!/bin/bash
echo 'this program suppose you work with mysql installed @127.0.0.1:3306. Say YES to continue'
read yes
if [ "$yes" == YES ]
then
  folder='cashbox'
  chmod 755 "$folder"
  touch "$folder"/.env.local
  echo 'Your SQL login : '
  read username
  echo 'Your SQL password : '
  read password
  echo 'database name : '
  read databasename
  setterEnv=APP_ENV=prod
  setterDb=DATABASE_URL=mysql://$username:$password@127.0.0.1:3306/$databasename
  echo "$setterEnv" >> "$folder"/.env.local
  echo "$setterDb" >> "$folder"/.env.local
  cd "$folder"
  composer install
  yarn install
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
  php bin/console doctrine:fixtures:load
  yarn encore prod
fi
