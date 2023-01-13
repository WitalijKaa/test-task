# DEBIAN 11

# login as root

# adduser hihi -ingroup www-data
# apt install sudo gnupg lsb-release -y
# visudo
# hihi ALL=(ALL) NOPASSWD:ALL
# sudo -u hihi mkdir /home/hihi/sh
# pscp C:\projects\sh\*.* hihi@91.92.128.146:/home/hihi/sh/
# sudo -u hihi chmod 744 /home/hihi/sh/init_13.sh
# sudo -u hihi /home/hihi/sh/init_13.sh

# cp /home/hihi/sh/.bash_aliases_root /root/.bash_aliases
# nano /root/.bashrc

# login as hihi
# sudo su

# timedatectl set-timezone Europe/Belgrade

# nano /etc/ssh/sshd_config
# PermitRootLogin no

# /home/hihi/sh/init_10.sh

cp /home/hihi/sh/php.gpg /etc/apt/trusted.gpg.d/php.gpg
sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'

curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /etc/apt/trusted.gpg.d/docker.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/trusted.gpg.d/docker.gpg] https://download.docker.com/linux/debian $(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null
curl -s https://api.github.com/repos/docker/compose/releases/latest | grep browser_download_url | grep docker-compose-linux-x86_64 | cut -d '"' -f 4 | head -n 1 | wget -O /home/hihi/sh/docker_c -qi -
chmod 744 /home/hihi/sh/docker_c
mv /home/hihi/sh/docker_c /usr/local/bin/docker-compose
curl -s https://raw.githubusercontent.com/docker/compose/master/contrib/completion/bash/docker-compose | tee /etc/bash_completion.d/docker-compose > /dev/null

apt update
apt upgrade -y

apt install gnupg -y
apt install curl -y
apt install wget -y
apt install apt-transport-https -y
apt install ca-certificates -y
apt install screen -y
apt install ufw -y
apt install nginx -y
apt install git -y
apt install composer -y
apt install nodejs -y
apt install npm -y
apt install imagemagick -y
apt install php8.2-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php8.1-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php8.0-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php7.4-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php7.3-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php7.2-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php7.1-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php7.0-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,ds,ds-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install php5.6-{bz2,bz2-dbgsym,cli,cli-dbgsym,common,common-dbgsym,curl,curl-dbgsym,fpm,fpm-dbgsym,gd,gd-dbgsym,imagick,imagick-dbgsym,imap,imap-dbgsym,mbstring,mbstring-dbgsym,mysql,mysql-dbgsym,opcache,opcache-dbgsym,pgsql,pgsql-dbgsym,xml,xml-dbgsym,zip,zip-dbgsym} -y
apt install postgresql-13 postgresql-contrib -y
apt install docker-ce docker-ce-cli containerd.io docker-compose-plugin -y

apt autoremove -y
apt-gen clean
rm /home/hihi/sh/php.gpg

ufw default deny incoming
ufw default allow outgoing
ufw allow 22
ufw allow 'Nginx Full'

cp /home/hihi/sh/nginx.conf /etc/nginx/nginx.conf
cp /home/hihi/sh/magic-stone-circuit.app /etc/nginx/sites-available
ln -s /etc/nginx/sites-available/magic-stone-circuit.app /etc/nginx/sites-enabled/magic-stone-circuit.app

cp /home/hihi/sh/php.ini /etc/php/8.2/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/8.2/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/8.1/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/8.1/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/8.0/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/8.0/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.4/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.4/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.3/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.3/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.2/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.2/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.1/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.1/cli/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.0/fpm/php.ini
cp /home/hihi/sh/php.ini /etc/php/7.0/cli/php.ini
cp /home/hihi/sh/php5.ini /etc/php/5.6/fpm/php.ini
cp /home/hihi/sh/php5.ini /etc/php/5.6/cli/php.ini

chown -R hihi:www-data /var/www

dpkg -i /home/hihi/sh/mysql-apt-config_0.8.24-1_all.deb
rm /home/hihi/sh/mysql-apt-config_0.8.24-1_all.deb
apt install mysql-server -y

sudo -u postgres psql -c "ALTER USER postgres WITH PASSWORD 'postgres';"

# systemctl enable --now docker

ufw enable
ufw status numbered

reboot

# end



