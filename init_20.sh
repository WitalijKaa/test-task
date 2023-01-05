# login as hihi
# /home/hihi/sh/init_20.sh

ln -s /var/www /home/hihi/www

rm -rf /home/hihi/sh/dotssh

mkdir /var/www/magic-stone-circuit.app
mkdir /var/www/sertificates
mkdir /var/www/magic-stone-circuit.app/main
mkdir /var/www/magic-stone-circuit.app/sertificate
git clone git@github.com:WitalijKaa/magic-stone-circuit.git /var/www/magic-stone-circuit.app/main
npm --prefix /var/www/magic-stone-circuit.app/main/ install
npm --prefix /var/www/magic-stone-circuit.app/main/ run build

cp /home/hihi/sh/ca_bundle.crt /var/www/magic-stone-circuit.app/sertificate/
cp /home/hihi/sh/certificate.crt /var/www/magic-stone-circuit.app/sertificate/
cp /home/hihi/sh/private.key /var/www/magic-stone-circuit.app/sertificate/
rm /home/hihi/sh/ca_bundle.crt
rm /home/hihi/sh/certificate.crt
rm /home/hihi/sh/private.key

ln -s /var/www/magic-stone-circuit.app/sertificate /var/www/sertificates/magic-stone-circuit.app
ln -s /var/www/magic-stone-circuit.app/sertificate /var/www/sertificates/www.magic-stone-circuit.app

# end

