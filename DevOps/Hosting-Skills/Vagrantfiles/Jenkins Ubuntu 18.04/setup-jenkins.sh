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