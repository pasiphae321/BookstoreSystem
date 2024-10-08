## 一、简介

该项目是一个用PHP编写的前后端分离的简易书店系统，存在SQL注入、CSRF、XSS漏洞和其对应防范方法，仅用于加深作者对web安全漏洞的底层原理的理解

## 二、先决条件

nginx、php-fpm、mysql

## 三、特性

- 前后端分离

- cookie、session底层原理

- web安全漏洞底层原理

## 三、安装

git clone该项目

以root身份执行initialize.sh即可完成安装

```shell
git clone https://github.com/pasiphae321/BookstoreSystem.git
sudo ./BookstoreSystem/initialize.sh
```