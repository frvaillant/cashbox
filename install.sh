#!/bin/bash
SCRIPTPATH="$( cd "$(dirname "$0")" ; pwd -P )"
CURRENT="$(pwd)"

err () {
    #Display a message on stderr and exit with the given code
    # $mess : message to display
    # $err : error code (default 10)
    local mess code
    mess="${1:-"something go wrong"}"
    code="${2:-"10"}"
    >&2 printf "ERROR : %s\n" "${mess}"
    exit "$code"
}
printf "Cashbox will be installed in %s\n" "$SCRIPTPATH"
printf 'this program suppose you work with mysql installed @127.0.0.1:3306. Say YES to continue : '
read -r yes
if [ "$yes" = 'YES' ]
then
  cd "$SCRIPTPATH" || err "Can't cd into ${SCRIPTPATH}"
  printf "Your SQL login : "
  read -r username
  printf "Your SQL password : "
  read -r -s password
  printf "\ndatabase name : "
  read -r databasename
  setterEnv="APP_ENV=prod"
  setterDb="DATABASE_URL=mysql://${username}:${password}@127.0.0.1:3306/${databasename}"
  echo "${setterEnv}" > ".env.local"
  echo "${setterDb}" >> ".env.local"
  composer install || err "Is composer alive?"
  yarn install || err "Error with Yarn"
  php bin/console doctrine:database:create || err "Error withDoctrine database create"
  php bin/console doctrine:migrations:migrate --no-interaction || err "Error with Doctrine database migrate"
  yarn encore prod || err "Error with Yarn"
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
exit 0
