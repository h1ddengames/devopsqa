## Setting up for Database and API Testing and Jenkins
Docker and Docker compose MUST be installed before following this guide.
The following was tested on Windows 10 Enterprise with Docker Desktop.

The db-api-jenkins folder contains the docker-compose.yaml required if the one in this readme does not work properly.

Note: If you want to run the database server + the api server + the jenkins server at the same time, just run ```docker-compose up -d``` because it will run apache2 web server, phpmyadmin database viewer, mysql database server, jenkins CI/CD server, and rest api server.

Note: Here is the command to stop all containers (MUST BE DONE ON POWERSHELL OR SUBSHELL WILL NOT BE ABLE TO FIGURE OUT WHAT -a MEANS):
  ```
  docker rm -f $(docker ps -a -q)
  ```

### Database Testing Setup
1. Create a folder called db-api-jenkins
2. Create a folder within db-api-jenkins called www (Put any html files you want to use for website/webapp testing inside this folder.)
3. Create a folder within db-api-jenkins called sql (DO NOT put any files inside this folder.)
4. Create a folder within db-api-jenkins called sqldumps (Put any .sql files you have within this folder.)
5. Create a docker-compose.yaml file.
6. Put the following code into the docker-compose.yaml file:
    Note: You should change the paths on the "source:" sections to match the location of your db-api-jenkins folder.
    ```
    version: '3.6'

    services:
      # apache2 is only required if using phpmyadmin.
      www:
        image: httpd:2.4
        ports: 
          - "80:80"
        volumes:
          - type: bind
            source: c:/Users/skarim/Downloads/db-api-jenkins/www
            target: /usr/local/apache2/htdocs
        restart: always
        links:
          - db
        networks:
          - dbphp

      # mysql database is required for database testing.
      db:
        image: mysql:5.7
        volumes:
          - type: bind
            source: c:/Users/skarim/Downloads/db-api-jenkins/sql
            target: /var/lib/mysql
          - type: bind
            source: c:/Users/skarim/Downloads/db-api-jenkins/sqldumps
            target: /usr/databases
        restart: always
        ports:
          - '3306:3306'
        environment:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: database
          MYSQL_USER: database-tester
          MYSQL_PASSWORD: password
        networks:
          - dbphp

      # phpmyadmin can be used as a database viewer but is not required.
      phpmyadmin:
        depends_on:
          - db
        image: phpmyadmin/phpmyadmin
        restart: always
        ports:
          - '8081:80'
        environment:
          PMA_HOST: db
          MYSQL_ROOT_PASSWORD: password 
        networks:
          - dbphp

      # jenkins can be used for remote/automated testing but is not required.
      jenkins:
        image: jenkins:2.60.3
        user: root
        ports: 
          - "8082:8080"
          - "8443:8443"
          - "50000:50000"
        volumes:
          - type: bind
            source: c:/Users/skarim/Downloads/db-api-jenkins/jenkins
            target: /var/jenkins_home
          - type: bind
            source: c:/Users/skarim/Downloads/db-api-jenkins/jenkins/home
            target: /home
          - type: bind
            source: c:/Users/skarim/Downloads/db-api-jenkins/jenkins/docker
            target: /var/run/docker.sock
        restart: always

      # rest api is required for rest api testing.
      rest:
        image: ericgoebelbecker/resttutorial
        ports: 
          - "8080:8080"
        restart: always

    networks:
      dbphp:
    volumes:
      db_data:
    ```
7. Open a terminal within the db-api-jenkins folder and run the following command:
    ```
    docker-compose up -d
    ```
8. If this is your first time setting up, run the following commands:
    ```
    # Docker exec into the mysql docker container
    docker exec -it db-api-jenkins_db_1 /bin/bash

    # Login as root
    mysql -p -u root 

    # Give the database-tester user the privilege of accessing all databases and tables.
    GRANT ALL PRIVILEGES ON *.* TO 'database-tester'@'%';

    # Exit the mysql dialogue
    exit

    # Run the sql script that will generate the tables and data contained within it by giving the root password.
    mysql -p -u root < usr/databases/mysqlsampledatabase/mysqlsampledatabase.sql

    # Same as above with another sql script. The schema must be used first in order to set up the table structure.
    mysql -p -u root < usr/databases/sakila-db/sakila-schema.sql

    # Same as above with another sql script.
    mysql -p -u root < usr/databases/sakila-db/sakila-data.sql
    ```
9. If you've already ran the setup above and you're restarting your computer or restarting your containers you can just run your database tests after running ```docker-compose up -d``` again.
10. If you've messed up your database(s), delete the contents of your dbadmin/sql folder then rerun the first time setup steps.

### Accessing the Mysql database
If you need a GUI that can help you visualize/ run sql statements on the mysql database:
1. Go to http://localhost:8081/
2. Login with the information you have provided in the section titled Database Testing Setup. 

### API Testing Setup
The following is if you want to run the api server separately:
1. First time setup:
    ```
    docker run -p 8080:8080 -d -–name tutorial ericgoebelbecker/resttutorial
    ```
2. If you restarted your computer then run the following to restart the API docker container:
    ```
    docker start tutorial
    ```
3. If you messed up the API docker container in any way, run the following commands to get rid of the container:
    ```
    # Find the container id of the API docker container
    docker container ls

    # Let's say the docker container's id was the following: efffc11505e8 
    # You only need to specify the first couple characters of the id.
    docker rm -f efff
    ```
4. Rerun the first time setup to restore your API docker container.

### Jenkins CI/CD Setup
The following is if you want to run the jenkins server separately:
1. First time setup:
    ```
    docker run -p 8082:8080 -d -–name jenkins jenkins:2.60.3
    ```
2. If you restarted your computer then run the following to restart the Jenkins docker container:
    ```
    docker start tutorial
    ```
3. If you messed up the Jenkins docker container in any way, run the following commands to get rid of the container:
    ```
    # Find the container id of the Jenkins docker container
    docker container ls

    # Let's say the docker container's id was the following: efffc11505e8 
    # You only need to specify the first couple characters of the id.
    docker rm -f efff
    ```
4. Rerun the first time setup to restore your Jenkins docker container.
5. Create a shell inside the container and download the headless webdrivers that will be used in your tests and add them to the Jenkins docker container's path.
    ```
    docker exec -it db-api-jenkins_jenkins_1 /bin/bash

    # To do: Add the lines required to download and add the webdrivers to path.
    ```
6. Open a browser on your host machine and go to http://127.0.0.1:8082 then open a file explorer on your machine and go to db-api-jenkins/jenkins folder. Inside you will find a secrets folder and inside that secrets folder you will find the initialAdminPassword file. Open that file and copy it's contents into your browser where it asks for Administrator password.
7. Setup Jenkins however you like/need. # To do: Add an explanation on how I would do it.