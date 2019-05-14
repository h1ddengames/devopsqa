---
title: "Installing Jenkins Guide"
date: 2019-05-12T1:17:21-07:00
layout: 'posts'
tags: ["Jenkins"]
---

## Installing Jenkins Guide
#

This guide uses Ubuntu 18.04, Java 8

Note: I have included a script to complete all the tasks below. Please change any usernames and passwords yourself. I have marked the lines that need usernames and passwords changed for security with "# Please change this/these values: "

Note: I am using Vagrant to create a VM so my user is vagrant and my home is located in /home/vagrant. If yours is different, make sure you update the script below to your environment.

Important Note: Make sure your browser version matches the web driver version. At the time of writing this warning, WebDriverManager is using chrome version 75 which is in beta while the currently supported package in Ubuntu is 74.x.x.

You can check your currently installed version of chrome by running:
    ```
    google-chrome --product-version
    ```

    OR

    ```
    chromium-browser --product-version
    ```

    setup-jenkins.sh
    ```
    #!/bin/bash
    echo "Setting up Jenkins."
    echo "Updating the package list and all packages to the latest version."
    sudo touch /home/vagrant/apt-output.txt
    sudo chmod 777 /home/vagrant/apt-output.txt
    sudo apt-get -y update &>> /home/vagrant/apt-output.txt
    sudo apt-get -y upgrade &>> /home/vagrant/apt-output.txt
    echo "Installing packages."
    sleep 2s
    sudo add-apt-repository -y ppa:canonical-chromium-builds/stage &>> /home/vagrant/apt-output.txt
    sudo apt update &>> /home/vagrant/apt-output.txt
    sudo apt-get -y install openjdk-8-jdk openjdk-8-jdk-headless openjdk-8-jre openjdk-8-jre-headless openjdk-11-jdk openjdk-11-jdk-headless openjdk-11-jre openjdk-11-jre-headless &>> /home/vagrant/apt-output.txt
    sudo apt-get -y install chromium-browser firefox chromium-chromedriver firefoxdriver &>> /home/vagrant/apt-output.txt
    wget https://github.com/mozilla/geckodriver/releases/download/v0.24.0/geckodriver-v0.24.0-linux64.tar.gz &>> /home/vagrant/apt-output.txt
    tar -xvzf geckodriver*
    sudo chmod +x geckodriver
    sudo mv geckodriver /usr/lib/geckodriver
    sudo rm gecko*
    echo "Finished installing packages."
    echo "Configuring environment."
    sleep 2s
    sudo cp /etc/environment /etc/environment.orig
    echo "JAVA_HOME='/usr/lib/jvm/java-11-openjdk-amd64'" | sudo tee -a /etc/environment
    echo "PATH='$PATH:/usr/lib/chromium-browser/:/usr/lib/firefoxdriver:/usr/lib/geckodriver'" | sudo tee -a /etc/environment
    source /etc/environment
    echo "Finished configuring the environment."
    echo "Installing jenkins."
    sleep 2s
    wget -O jenkins.deb https://pkg.jenkins.io/debian-stable/binary/jenkins_2.164.3_all.deb &>> /home/vagrant/apt-output.txt
    sudo dpkg -i jenkins.deb
    sudo apt-get -fy install
    sudo rm jenkins.deb
    echo "Finished installing jenkins."
    echo "You may access the machine through the following ip: "
    echo "$(ip addr | grep "inet 192")" | sed 's-inet --g' |sed 's-/24 brd 192.168.0.255 scope global dynamic enp0s8-:8080-g'
    echo "You will have to use the following password to unlock jenkins: "
    sudo cat /var/lib/jenkins/secrets/initialAdminPassword
    ```

### Installing Java
1. Run the following command to download both jdk and jre.
    ```
    sudo apt-get install -y openjdk-8-jdk openjdk-8-jdk-headless openjdk-8-jre openjdk-8-jre-headless openjdk-11-jdk openjdk-11-jdk-headless openjdk-11-jre openjdk-11-jre-headless
    ```

2. Set JAVA_HOME by running the following command:
    ```
    sudo cp /etc/environment /etc/environment.orig
    echo "JAVA_HOME='/usr/lib/jvm/java-8-openjdk-amd64'" | sudo tee -a /etc/environment
    source /etc/environment
    ```

### Installing WebDrivers and Selenium
Note: You can find where a package has been installed to by running the following command:
    ```
    dpkg -L packagename
    ```

1. Run the following command to download chromedriver:
    ```
    sudo add-apt-repository -y ppa:canonical-chromium-builds/stage
    sudo apt update
    sudo apt-get -y install chromium-browser chromium-chromedriver
    ```
    Note: Installs to /usr/lib/chromium-browser/
2. Run the following command to download firefoxdriver:
    ```
    sudo apt-get -y install firefox firefoxdriver
    ```
    Note: Installs to /usr/lib/firefoxdriver
3. Run the following commands to download and install geckodriver:
    ```
    wget https://github.com/mozilla/geckodriver/releases/download/v0.24.0/geckodriver-v0.24.0-linux64.tar.gz
    tar -xvzf geckodriver*
    sudo chmod +x geckodriver
    sudo mv geckodriver /usr/lib/geckodriver
    rm gecko*
    ```
4. Put the drivers in the Path
    ```
    echo "PATH='$PATH:/usr/lib/chromium-browser/:/usr/lib/firefoxdriver:/usr/lib/geckodriver'" | sudo tee -a /etc/environment
    source /etc/environment
    ```
    
### Installing Jenkins
1. Download Jenkins:
    ```
    wget -O jenkins.deb https://pkg.jenkins.io/debian-stable/binary/jenkins_2.164.3_all.deb
    ```
2. Install Jenkins:
    ```
    sudo dpkg -i jenkins.deb
    sudo apt-get install -fy
    sudo rm jenkins.deb
    ```
3. Get the IP address of the server:
    ```
    ip addr | grep "inet 192"
    ```
4. Open a web browser and go to the ipaddress:8080
   
5. Run the following command in order to unlock Jenkins.
    ```
    sudo cat /var/lib/jenkins/secrets/initialAdminPassword
    ```

### Configuring Jenkins
1. After unlocking Jenkins, select "Install suggested plugins". Then wait as Jenkins gets started.
2. Create the first Admin User by giving a username, password, full name, and email address.
3. Give the URL where people can expect to find the Jenkins server.
4. Click the Jenkins dropdown > Manage Jenkins > Global Tool Configuration.
5. Click the Add JDK button then point to the location of the JDK. Then click save.
    ```
    Name: java-11-openjdk-amd64
    JAVA_HOME: /usr/lib/jvm/java-11-openjdk-amd64
    ```
6. Click the Add Maven button then either point to the location of the Maven install or allow Jenkins to automatically install it. Then click save.
6. Click Jenkins dropdown > Plugin Manager > Available. Then in the Filter search textbox, type in Maven. Select Maven Integration then click Download now and install after restart.
7. Once Jenkins has restarted, login and select New Item.
8. Give the project name then select Maven project.
9. Select the GitHub project checkbox then give the url to the github project.
10. Select Git under Source Code Management then give the url to the github project.
11. Under Build > Goals and Options, give the following goals and options: ```clean verify test```
12. Once finished, click save then select Build Now.