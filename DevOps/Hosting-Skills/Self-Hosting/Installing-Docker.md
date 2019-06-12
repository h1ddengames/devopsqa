---
title: "Installing Docker and Docker Compose Guide"
date: 2019-06-10T12:17:21-07:00
layout: 'posts'
tags: ["Docker, Compose"]
---

## Installing Docker and Docker Compose
#

This guide uses Ubuntu 18.04

Note: I have included a script to complete all the tasks below. Please change any usernames and passwords yourself. I have marked the lines that need usernames and passwords changed for security with "# Please change this/these values: "

Note: I am using Vagrant to create a VM so my user is vagrant and my home is located in /home/vagrant. If yours is different, make sure you update the script below to your environment.

Note: You should have the Vagrantfile, setup-docker-compose.sh, and docker-compose.yaml in the same folder.

```Vagrantfile:```
```
Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/bionic64"

  config.vm.network "forwarded_port", guest: 80, host: 80
  config.vm.network "forwarded_port", guest: 3306, host: 3306
  config.vm.network "forwarded_port", guest: 8080, host: 8080

  config.vm.provider "virtualbox" do |vb|
    vb.name = "Ubuntu Master"
    vb.gui = false
    vb.cpus = 4
    vb.memory = 2048
  end

  config.vm.provision "shell", inline: <<-SHELL
    # Copy the setup bash script.
    sudo cp /vagrant/setup-docker-compose.sh /home/vagrant/
    # Make the bash script executable.
    sudo chmod +x /home/vagrant/setup-docker-compose.sh
    # Create a directory for the docker-compose.yaml file and move the file to that folder.
    sudo mkdir /home/vagrant/docker
    sudo cp /vagrant/docker-compose.yaml /home/vagrant/docker
    # Run the bash script
    sudo bash /home/vagrant/setup-docker-compose.sh
  SHELL
end
```

```setup-docker-compose.sh:```
```
#!/bin/bash
sudo apt-get -y update
sudo apt-get -y upgrade
echo -e '\e[41;37m'"\033[1m Finished updating and upgrading repos and programs. \033[0m"
sudo apt-get -y install apt-transport-https ca-certificates curl gnupg-agent software-properties-common
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
echo -e '\e[41;37m'"\033[1m Added required software, keys, and repos. \033[0m"
sudo apt-get -y update
sudo apt-get -y upgrade
echo -e '\e[41;37m'"\033[1m Finished updating and upgrading repos and programs. \033[0m"
sudo apt-get -y install docker-ce docker-ce-cli containerd.io
sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo curl -L https://raw.githubusercontent.com/docker/compose/1.24.0/contrib/completion/bash/docker-compose -o /etc/bash_completion.d/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
echo -e '\e[41;37m'"\033[1m Finished installing docker and docker-compose. \033[0m"
cd /home/vagrant/docker/ && sudo docker-compose up -d
echo -e '\e[41;37m'"\033[1m Finished running docker-compose \033[0m"
```

```docker-compose.yml```
```
version: '3'

services:
  # apache2
  www:
    image: httpd:2.4
    ports: 
      - "80:80"
    volumes:
      - ./www:/var/www/html/
    links:
      - db
    networks:
      - dbphp
  # mysql database
  db:
    image: mysql:5.7
    volumes:
      - db_data:/var/lib/mysql
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: database
      MYSQL_USER: database-tester
      MYSQL_PASSWORD: password
    networks:
      - dbphp
  # phpmyadmin
  phpmyadmin:
    depends_on:
      - db
    image: phpmyadmin/phpmyadmin
    restart: always
    ports:
      - '8080:80'
    environment:
      PMA_HOST: db
      MYSQL_ROOT_PASSWORD: password 
    networks:
      - dbphp
networks:
  dbphp:
volumes:
  db_data:
```

#
### Accessing the LAMP Stack
1. To access apache2 server go to http://localhost
2. To access phpmyadmin server go to http://localhost:8080
3. To access mysql use steps 5-6 from the Setting up the containers section.


#
### Setting up the containers (externally)
1. Start the vagrant vm:
    ```
    vagrant up
    ```
2. On your host machine run:
    ```
    vagrant ssh
    ```
3. Once logged in, go into the following directory:
    ```
    cd /home/vagrant/docker
    ```
4. Run the docker-compose command to start the docker containers:
    ```
    sudo docker-compose up -d
    ```
5. Run the docker command to display all containers:
    ```
    sudo docker ps
    ```
6. Run the docker command to run /bin/bash terminal inside the container:
    ```
    sudo docker exec -it docker_db_1 /bin/bash
    ```
7. Logging into mysql
    ```
    mysql -u root -p
    ```
8. Enter the password that was given in the docker-compose.yaml file then run whatever mysql commands you want.

#
### Destroying the containers (teardown)
1. On your host machine run:
    ```
    vagrant ssh
    ```
2. Once ssh'd into your vagrant machine run the following to delete all containers and persistent volumes:
    ```
    docker-compose down --volumes
    ```
    OR if you would like to save the volumes
    ```
    docker-compose down
    ```

#
### Installing Docker
1. Update the repository listing and installed programs
    ```
    sudo apt-get update -y && sudo apt-get upgrade -y
    ```
2. Install the required programs first:
   ```
    sudo apt-get -y install apt-transport-https ca-certificates curl gnupg-agent software-properties-common
   ```
3. Add the Docker key and repository:
    ```
    sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

    sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
    ```
4. Update the repository list:
    ```
    sudo apt-get -y update
    sudo apt-get -y upgrade
    ```
5. Install Docker with the following command:
    ```
    sudo apt-get -y install docker-ce docker-ce-cli containerd.io
    ```
6. Check that docker has been installed:
    ```
    docker-compose --version
    ```

#
### Installing Docker Compose
1. Install Docker Compose with the following command:
    ```
    sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    ```
2. Allow the program to be run by setting up the proper permission
    ```
    sudo chmod +x /usr/local/bin/docker-compose
    ```
3. Check that docker-compose has been installed:
    ```
    docker-compose --version
    ```
4. Install Docker-Compose autocomplete for bash
    ```
    sudo curl -L https://raw.githubusercontent.com/docker/compose/1.24.0/contrib/completion/bash/docker-compose -o /etc/bash_completion.d/docker-compose
    ```

#
### Using Docker Compose
1. Create a directory to hold the docker-compose.yaml file.
    ```
    mkdir ~/docker
    ```
2. Create a docker-compose.yml
    Note: there are 2 spaces where there are indents (NOT TABS or 4 spaces)
    ```
    version: '3'

    services:
        # apache2
        www:
            image: httpd:2.4
            ports: 
            - "80:80"
            volumes:
            - ./www:/var/www/html/
            links:
            - db
            networks:
            - dbphp
        # mysql database
        db:
            image: mysql:5.7
            volumes:
            - db_data:/var/lib/mysql
            restart: always
            environment:
                MYSQL_ROOT_PASSWORD: password
                MYSQL_DATABASE: database
                MYSQL_USER: database-tester
                MYSQL_PASSWORD: password
            networks:
            - dbphp
        # phpmyadmin
        phpmyadmin:
            depends_on:
            - db
            image: phpmyadmin/phpmyadmin
            restart: always
            ports:
            - '8080:80'
            environment:
                PMA_HOST: db
                MYSQL_ROOT_PASSWORD: password 
                networks:
                - dbphp
        networks:
            dbphp:
        volumes:
            db_data:
    ```
3. Run Docker Compose:
    ```
    docker-compose up -d
    ```
4. In order to stop Docker Compose:
    ```
    docker-compose down --volumes
    ```