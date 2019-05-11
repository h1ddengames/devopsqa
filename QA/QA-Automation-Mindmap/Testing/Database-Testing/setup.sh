#!/bin/sh
echo "Setting up MYSQL, PHPMyAdmin, and the databases to test..."
# Updates the repo list.
sudo apt-get -y update
# Updates all software that has updates
sudo apt-get -y upgrade
# Installs mysql-server
sudo apt-get install -y apache2 mysql-server
# Password locks the root user of mysql.
sudo mysql -e "UPDATE mysql.user SET authentication_string=password('newpassword') WHERE user='root'"
# Deletes all current users.
sudo mysql -e "DROP USER ''@'localhost'"
sudo mysql -e "DROP USER ''@'$(hostname)'"
# Creates a database-tester user and gives them complete access.
sudo mysql -e "CREATE USER 'database-tester'@'localhost' IDENTIFIED BY 'password'"
sudo mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'database-tester'@'localhost'"
# Password locks the database-tester user.
sudo mysql -e "UPDATE mysql.user SET authentication_string=password('database') WHERE user='database-tester'"
# Add new databases
#sudo mysql -e "CREATE DATABASE sample_database"
#sudo mysql -e "CREATE DATABASE employees_db"
# Removes unused database tables.
sudo mysql -e "DROP DATABASE test"
# Applies all changes.
sudo mysql -e "FLUSH PRIVILEGES"
# Installs php and phpmyadmin
sudo apt-get install -y php libapache2-mod-php php-mysql phpmyadmin php-mbstring php-gettext
sudo phpenmod mbstring
sudo systemctl restart apache2
# Moves the database files/folders from the shared /vagrant folder to the home folder of the vagrant user.
cp -R /vagrant/mysqlsampledatabase/ /home/vagrant/
cp -R /vagrant/employees_db /home/vagrant
# Imports the database from the .sql files into mysql-server.
#cd /home/vagrant/mysqlsampledatabase && sudo mysql -t -u database-tester -p sample_database < mysqlsampledatabase.sql
#cd /home/vagrant/employees_db  && sudo mysql -t -u database-tester -p employees_db < employees.sql
cd /home/vagrant/mysqlsampledatabase && sudo mysql -t < mysqlsampledatabase.sql
cd /home/vagrant/employees_db  && sudo mysql -t < employees.sql
echo "Setup complete."