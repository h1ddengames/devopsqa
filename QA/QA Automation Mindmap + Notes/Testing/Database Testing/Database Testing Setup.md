## Database Testing

#
### Setting up the environment for database testing

#
#### Download the following database files
employees_db-full-1.0.6.tar.bz2 From: http://www.mysqltutorial.org/mysql-sample-database.aspx

mysqlsampledatabase From: https://launchpad.net/test-db/+download

#
#### Getting a Ubuntu 18.04 VM running with Vagrant
1. Download Vagrant from: https://www.vagrantup.com/
2. Install Vagrant with the default settings.
3. Create a directory and name it ```ubuntu-database-vagrant```
4. Move into the created directory and run the following command to download Ubuntu 18.04 for Vagrant:
    ```
    vagrant init ubuntu/bionic64
    ```
5. Create a bash script named setup.sh and paste the following:
    ```
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
    sudo mysql -e "CREATE DATABASE sample_database"
    sudo mysql -e "CREATE DATABASE employees_db"
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
    cd /home/vagrant/mysqlsampledatabase && mysql -u database-tester -p sample_database < mysqlsampledatabase.sql
    cd /home/vagrant/employees_db  && mysql -u database-tester -p employees_db < employees.sql
    echo "Setup complete."
    ```
6. Move the database files/folders into the current directory.
    
    Note: your directory should currently have the following file/folder structure:
    
    ```
    - .vagrant
    - employees_db
    - mysqlsampledatabase
    - setup.sh
    - ubuntu18.04.box
    - ubuntu-bionic-18.04-cloudimg-console.log
    - Vagrantfile
    ```
7. Modify your Vagrant file to look like this:
    ```
    # -*- mode: ruby -*-
    # vi: set ft=ruby :

    Vagrant.configure("2") do |config|
    config.vm.box = "ubuntu/bionic64"
    # Gives an ip address through dhcp.
    config.vm.network "private_network", type: "dhcp"
    # Forwards port 80 on the VM to port 8080 on the host machine.
    config.vm.network "forwarded_port", guest: 80, host: 8080
    # Forwards port 3306 on the VM to port 3306 on the host machine.
    config.vm.network "forwarded_port", guest: 3306, host: 3306

    config.vm.provider "virtualbox" do |vb|
        vb.name = "VM for Testing"
        vb.gui = false
        # Gives the VM 4GB of RAM.
        vb.memory = "4096"
        # Gives the VM 2 CPUs
        vb.cpus = 2
    end

    config.vm.provision "shell", inline: <<-SHELL
        cp /vagrant/setup.sh /home/vagrant
    SHELL
    end
    ```

8. Run the following command to start a VM using Vagrant:
    ```
    vagrant up
    ```
9. Once the previous vagrant command finishes, run the following command to ssh into the newly created vm.
    ```
    vagrant ssh
    ```

    Note: vagrant uses the following login for it's ssh:
    ``` 
    username: vagrant
    password: vagrant
    ```

    But in order to login with only password or use a sftp client, you must ```vagrant ssh``` into the vm, change ```/etc/ssh/sshd_config```'s line from ```PasswordAuthentication no``` to ```PasswordAuthentication yes```.
10. Run the following commands to finish the setup process:
    ```
    sudo -i
    bash /home/vagrant/setup.sh
    sudo nano /usr/share/phpmyadmin/libraries/sql.lib.php
    CTRL + SHIFT + _ 611 ENTER
    # REPLACE 
    (count($analyzed_sql_results['select_expr'] == 1) 
    # WITH 
    (count($analyzed_sql_results['select_expr']) == 1
    ```
11. Visit ```http://172.28.128.7/phpmyadmin/``` but replace the ip address with the ip address of the VM.

    Note: in order to get the ip address of the VM run the following command: 
    ```
    ip addr | grep 'inet '
    ``` 
    Also note: the space after "inet" is intentional. Choose the ip address that starts with 172.X.X.X

12. Update the file /etc/mysql/mysql.conf.d/mysqld.cnf
    ```
    Change: bind-address = 127.0.0.1
    To: bind-address = 0.0.0.0
    ``` 

13. Run the following commands:
    ```
    sudo mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'database-tester'@'%' IDENTIFIED BY 'database'"
    sudo service mysql restart
    ```