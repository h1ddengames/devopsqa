#!/bin/bash
echo "Setting up Wordpress."
echo "Configuring mysql."
sleep 2s
sudo mysql -e "CREATE DATABASE wordpress DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
# Please change this/these values: wordpressuser, password
sudo mysql -e "GRANT ALL ON wordpress.* TO 'wordpressuser'@'localhost' IDENTIFIED BY 'password'"
sudo mysql -e "FLUSH PRIVILEGES"
echo "Finished configuring mysql."
echo "Updating the package list and all packages to the latest version."
sleep 2s
sudo apt-get -y update &>> /home/vagrant/apt-output.txt
echo "Installing packages."
sleep 2s
sudo apt-get -y install php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip &>> /home/vagrant/apt-output.txt
echo "Finished installing packages."
echo "Downloading and installing wordpress"
sleep 2s
wget -O /home/vagrant/latest.tar.gz https://wordpress.org/latest.tar.gz
cd /var/www && sudo tar xpf /home/vagrant/latest.tar.gz
sudo touch /var/www/wordpress/.htaccess
sudo mkdir /var/www/wordpress/wp-content/upgrade
sudo chown -R www-data:www-data /var/www/wordpress
echo "Finished downloading and installing wordpress"
echo "Configuring apache2"
sleep 2s
sudo -s cat > wordpress.conf <<EOL
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/wordpress
    ServerName localhost

    <Directory /var/www/wordpress/>
        AllowOverride All
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
EOL
sudo mv wordpress.conf /etc/apache2/sites-available/wordpress.conf
sudo a2enmod rewrite
sudo a2ensite wordpress.conf
sudo a2dissite 000-default.conf
sudo service apache2 reload
sudo find /var/www/wordpress/ -type d -exec chmod 750 {} \;
sudo find /var/www/wordpress/ -type f -exec chmod 640 {} \;
echo "Finished configuring apache2"
echo "Finished installing wordpress."
echo "You may access the machine through the following ip: "
ip addr | grep "inet 192"