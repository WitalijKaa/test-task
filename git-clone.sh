# login as hihi
# /home/hihi/sh/git-clone.sh -r 'repo' -b 'branch' -f 'folder' -s 'subdomain' -d '? database (pg|my or migration m|pgm|mym) type if need to migrate laravel or\and create DB with branch name'
# /home/hihi/sh/git-clone.sh -r -b -f -s

while getopts r:b:f:s:d: flag
do
    case "${flag}" in
        r) repo=${OPTARG};;
        b) branch=${OPTARG};;
        f) folder=${OPTARG};;
        s) subdomain=${OPTARG};;
        d) database=${OPTARG};;
    esac
done

git clone git@github.com:WitalijKaa/$repo.git /var/www/git/$folder
git -C /var/www/git/$folder checkout $branch
if [ -f /var/www/git/$folder/composer.lock ]; then
    composer install --working-dir /var/www/git/$folder/ --ignore-platform-reqs
fi
if [ -f /var/www/git/$folder/package-lock.json ]; then
    npm --prefix /var/www/git/$folder/ install
    npm --prefix /var/www/git/$folder/ run build
    npm --prefix /var/www/git/$folder/ run prod
fi
if [ -f /var/www/git/$folder/.env.example ]; then
  cp /var/www/git/$folder/.env.example /var/www/git/$folder/.env
fi

rm /var/www/$subdomain
ln -s /var/www/git/$folder /var/www/$subdomain
chmod 774 $(find /var/www/git/$folder/ -type d)
chmod 664 $(find /var/www/git/$folder/ -type f)

php /var/www/git/$folder/artisan key:generate --ansi
if [ "pg" = "$database" ] || [ "pgm" = "$database" ]; then
  sudo -u postgres psql -c 'create database $branch;'
fi
if [ "m" = "$database" ] || [ "pgm" = "$database" ] || [ "mym" = "$database" ]; then
  sudo -u postgres psql -c 'create database $branch;'
fi
php /var/www/git/$folder/artisan migrate

# sudo -u postgres psql -c "ALTER USER postgres WITH PASSWORD 'postgres';"

# end


