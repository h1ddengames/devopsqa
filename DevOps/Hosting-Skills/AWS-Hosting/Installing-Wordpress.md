---
title: "Installing Wordpress Guide"
date: 2019-05-10T12:17:21-07:00
layout: 'posts'
tags: ["LAMP", "Wordpress"]
---

## Installing Wordpress Guide
#

This guide uses Ubuntu 18.04

### LAMP Installation
[Follow my installation guide on github](Installing-LAMP.md)

### Setup SSL

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
    sudo apt update
    sudo apt install php-curl php-gd php-mbstring php-xml php-xmlrpc php-soap php-intl php-zip
    ```