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
echo -e '\e[41;37m'"\033[1m ip addr: \033[0m"
ip addr | grep "inet "