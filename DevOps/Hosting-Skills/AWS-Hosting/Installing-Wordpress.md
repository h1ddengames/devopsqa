---
title: "Installing Wordpress Guide"
date: 2019-05-10T1:17:21-07:00
layout: 'posts'
tags: ["LAMP", "Wordpress"]
---

## Installing Wordpress Guide
#

This guide uses Ubuntu 18.04

### LAMP Installation
[Follow my installation guide on github](Installing-LAMP.md)

### Create MySQL User and Database for WordPress
1. Run the following command to login to mysql as root
    ```
    sudo mysql
    ```
2. Run the following command to create the database
    ```
    CREATE DATABASE wordpress DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
    ```
3. Run the following command to create the wordpress user:
    ```
    GRANT ALL ON wordpress.* TO 'wordpressuser'@'localhost' IDENTIFIED BY 'password';
    ```
4. Update MYSQL privileges then exit:
    ```
    FLUSH PRIVILEGES;
    EXIT;
    ```

### Installing PHP Extensions
1. Run the following command to get all the required php extensions for wordpress:
    ```
    sudo apt-get -y update
    sudo apt-get -y install php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip
    ```

2. Restart apache2 in order to load the new php extensions
    ```
    sudo service apache2 restart
    ```

### Installing WordPress
1.  Download wordpress as a tar.gz file.
    ```
    wget -O /home/vagrant/latest.tar.gz https://wordpress.org/latest.tar.gz
    ```
2.  Go into the /var/www directory and extract the directory.
    ```
    cd /var/www
    sudo tar xpf /home/vagrant/latest.tar.gz
    ```
3. Give the web server ownership of the directory.
    ```
    sudo chown -R www-data:www-data /var/www/wordpress
    ```

### Configure the WebServer
1. Copy the default config.
    ```
    sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/wordpress.conf
    ```
2. Modify the new config.
    ```
    sudo nano /etc/apache2/sites-available/wordpress.conf
    ```

    Modify the opened config to this:
    ```
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
    ```
3. Enable the rewrite mod then enable the new config file then reload apache2:
    ```
    sudo a2enmod rewrite
    sudo a2ensite wordpress.conf
    sudo a2dissite 000-default.conf
    sudo service apache2 reload
    ```
4. Configure the permissions for wordpress directories
    ```
    sudo find /var/www/wordpress/ -type d -exec chmod 750 {} \;
    sudo find /var/www/wordpress/ -type f -exec chmod 640 {} \;
    ```

### Configure WordPress
1. Create a dummy .htaccess file for later:
    ```
    sudo touch /var/www/wordpress/.htaccess
    ```
2. Create a upgrade directory for wordpress:
    ```
    mkdir /var/www/wordpress/wp-content/upgrade
    ```
3. You can use the web interface to complete the setup.

    Note: At this point you should have access to the dashboard. It is up to you to create whatever website you would like.


### Secure WordPress Setup Using Self Signed SSL Certificate
- Note: Use this if you are testing this install locally ie. (localhost)

### Secure WordPress Setup Using Setup SSL with Let's Encrypt
- Note: Use this if you have a domain name ie. (www.thisisyourdomainname.com)