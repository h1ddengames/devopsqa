#!/bin/bash
# Please change this/these values: password, root, password
APP_PASS="password"
ROOT_PASS="root"
APP_DB_PASS="password"
echo "Setting up a LAMP Stack."
echo "Updating the package list and all packages to the latest version."
sleep 2s
sudo touch /home/vagrant/apt-output.txt && sudo chmod 777 apt-output.txt
sudo apt-get -y update &>> /home/vagrant/apt-output.txt
sudo apt-get -y upgrade &>> /home/vagrant/apt-output.txt
echo "Preparing for phpmyadmin unattended install."
echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password $APP_PASS" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password $ROOT_PASS" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password $APP_DB_PASS" | debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2" | debconf-set-selections
echo "Configuring for phpmyadmin install finished."
echo "Installing packages."
sleep 2s
sudo apt-get -y install curl apache2 mysql-server php libapache2-mod-php php-mysql phpmyadmin &>> /home/vagrant/apt-output.txt
echo "Finished installing packages."
echo "Configuring mysql."
sleep 2s
# Please change this/these values: password('root')
sudo mysql -e "UPDATE mysql.user SET authentication_string=password('root') WHERE user='root'"
# Please change this/these values: db, password
sudo mysql -e "CREATE USER 'db'@'localhost' IDENTIFIED BY 'password'"
# Please change this/these values: db, password
sudo mysql -e "CREATE USER 'db'@'%' IDENTIFIED BY 'password'"
sudo mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'db'@'localhost'"
sudo mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'db'@'%'"
# Please change this/these values: password('db'), user='db'
sudo mysql -e "UPDATE mysql.user SET authentication_string=password('db') WHERE user='db'"
echo "Finished configuring mysql."
echo "Finished installing LAMP stack."
echo "You may access the machine through the following ip: "
ip addr | grep "inet 192"