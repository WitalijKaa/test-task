server {
    listen 80;
    listen [::]:80 ipv6only=on;

    server_name ~^(?<subDom>.*)\.magic-stone-circuit\.app ~^(?<magic>magic)-stone-circuit\.app 91.92.128.146;

    root /var/www/magic-stone-circuit.app/main;
    index index.html;
    autoindex off;

    access_log /var/log/nginx/msc.http.log;
    error_log /var/log/nginx/msc.http.err.log;

    if ($subDom) {
        return 308 https://$subDom.magic-stone-circuit.app;
    }

    if ($magic) {
        return 301 https://magic-stone-circuit.app;
    }

    location / {
        try_files $uri $uri/ =404;
    }
}

server {
    keepalive_timeout 80;
    charset utf-8;
    listen 443 deferred http2 ssl;
    listen [::]:443 deferred http2 ssl ipv6only=on;

    ssl_certificate /var/www/sertificates/$ssl_server_name/certificate.crt;
    ssl_certificate_key /var/www/sertificates/$ssl_server_name/private.key;

    server_name ~^(?<subDom>.*)\.magic-stone-circuit\.app;

    if (!-d "/var/www/$subDom") {
        return 300 https://magic-stone-circuit.app;
    }

    set $dir "magic-stone-circuit.app/main";
    if ($subDom) { set $dir $subDom; }
    if (-d "/var/www/$subDom/public") { set $dir "$subDom/public"; }

    root /var/www/$dir;
    index index.html index.php;
    autoindex off;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header Strict-Transport-Security 'max-age=15552000';
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_ciphers HIGH:!RC4:!aNULL:!MD5:!kEDH;

    access_log /var/log/nginx/msc.https.log;
    error_log /var/log/nginx/msc.https.err.log;
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

}

