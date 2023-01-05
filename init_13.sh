mkdir /home/hihi/.ssh
cp /home/hihi/sh/authorized_keys /home/hihi/.ssh/
rm /home/hihi/sh/authorized_keys
chmod 600 /home/hihi/.ssh/authorized_keys
cp /home/hihi/sh/servak /home/hihi/.ssh/
rm /home/hihi/sh/servak
chmod 600 /home/hihi/.ssh/servak
cp /home/hihi/sh/servak.pub /home/hihi/.ssh/
rm /home/hihi/sh/servak.pub
chmod 600 /home/hihi/.ssh/servak.pub
cp /home/hihi/sh/servak.putty.ppk /home/hihi/.ssh/
rm /home/hihi/sh/servak.putty.ppk
chmod 600 /home/hihi/.ssh/servak.putty.ppk
cp /home/hihi/sh/servak.putty.pub /home/hihi/.ssh/
rm /home/hihi/sh/servak.putty.pub
chmod 600 /home/hihi/.ssh/servak.putty.pub

chmod 744 /home/hihi/sh/init_10.sh
chmod 744 /home/hihi/sh/init_20.sh
chmod 744 /home/hihi/sh/git-clone.sh

cp /home/hihi/sh/.bash_aliases /home/hihi/.bash_aliases

# end

