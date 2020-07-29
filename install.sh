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
  yarn encore prod
  echo '*************************************'
  echo '*************************************'
  echo '*              CASHBOX              *'
  echo '*     WAS SUCCESSFULLY INSTALLED    *'
  echo '*      WE HOPE YOU WILL ENJOY IT    *'
  echo '*                **                 *'
  echo '*           run cd cashbox          *'
  echo '*        Launch your server         *'
  echo '*                **                 *'
  echo '*           LOG INTO WITH           *'
  echo '*            admin:admin            *'
  echo '*                 OR                *'
  echo '*             user:user             *'
  echo '* /!\/!\/!\/!\ WARNING /!\/!\/!\/!\ *'
  echo '* Do not forget to change admin and *'
  echo '*           user password           *'
  echo '* /!\/!\/!\/!\/!\/!\/!\/!\/!\/!\/!\ *'
  echo '*************************************'
  echo '*************************************'
fi
