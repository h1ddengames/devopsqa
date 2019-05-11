---
title: "Installing LAMP Guide"
date: 2019-05-10T12:17:21-07:00
layout: 'posts'
tags: ["LAMP"]
---

## Installing LAMP Guide
#

This guide uses Ubuntu 18.04

### Installing Apache
1. Run the following command to install apache2:
    ```
    sudo apt-get install -y apache2
    ```
2. Check that the install worked by running the following command to get the ip address:
    ```
    ip addr | grep "inet"
    ```

    The ip address should start with 192.

    -- OR --
    
    Run the following commands if you don't have a second computer/ you are running a server version of Ubuntu 18.04.
    ```
    sudo apt-get install -y curl
    curl localhost
    ```

    The above command should return the following:
    ```
    ...
          </div>
        </div>
        <div class="validator">
        </div>
    </body>
    </html>
    ```

### Installing MySQL
1. Run the following command to install MySQL:
    ```
    sudo apt install -y mysql-server
    ```

2. Run the following command to setup the MySQL install:
    ```
    sudo mysql_secure_installation
    ```

    -- OR --

    Run add the following commands to a file named mysql-setup.sh to do the same things as the above command:
    ```
    sudo nano mysql-setup.sh
    ```

    ```
    #!/bin/bash
    # Update the password for the user named 'root' with the password 'root'.
    sudo mysql -e "UPDATE mysql.user SET authentication_string=password('root') WHERE user='root'"
    # Creates a user named 'db' with the password 'password' and gives them complete access.
    sudo mysql -e "CREATE USER 'db'@'localhost' IDENTIFIED BY 'password'"
    sudo mysql -e "CREATE USER 'db'@'%' IDENTIFIED BY 'password'"
    sudo mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'db'@'localhost'"
    sudo mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'db'@'%'"
    # Password locks the user 'db'.
    sudo mysql -e "UPDATE mysql.user SET authentication_string=password('db') WHERE user='db'"
    ```

3. Edit the mysql config file in order to allow access to the database from any ip address:
    ```
    sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf
    ```

    Then comment out the following line:
    ```
    #bind-address           = 127.0.0.1
    ```

    Then restart the mysql-server
    ```
    sudo service mysql restart
    ```

### Installing PHP and PhpMyAdmin
1. Run the following commands to install PHP
    ```
    sudo apt-get install -y php libapache2-mod-php php-mysql phpmyadmin
    ```

    Note: When installing phpmyadmin, make sure you press TAB to select apache2, then press ENTER to select. Then press ENTER to allow phpmyadmin to configure the database. Finally give a password to phpmyadmin to register with the database server.

2. Check that the install worked by running the following command:
    ```
    curl http://localhost/phpmyadmin/
    ```
    
    The above command should give the following output:
    ```
    ...
        </form></div><div id="pma_footer"></div></div></body></html>
    ```