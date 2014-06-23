#!/bin/sh

#if [ -z "$1" ]
#  then
#    echo "please supply a username for ssh operations as argument "
#    exit 1
#fi

BRANCH="master"
REV=$(git rev-parse HEAD)

git pull origin master
git checkout $BRANCH

app/console cache:clear --env prod
app/console assetic:dump --env prod

scp -r ./web/js/ "milos@188.226.235.234":/tmp/js
scp -r ./web/css/ "milos@188.226.235.234":/tmp/css

ssh -A "milos@188.226.235.234" << ENDSSH
sudo su
service php5-fpm stop
cd /usr/share/nginx/www
cp /tmp/js/* web/js/
cp /tmp/css/* web/css/
echo "checking out master"
git checkout master
git fetch
git pull origin master
git reset --hard origin/master
tar -zxvf vendor.tar.gz

app/console cache:clear --env prod
app/console assets:install web

app/console doctrine:migrations:migrate  --no-interaction
chown -R www-data:www-data /usr/share/nginx/www/
rm -Rf /tmp/js
rm -Rf /tmp/css
service php5-fpm restart
sudo service nginx restart