## 一、简介

该项目是一个用PHP编写的前后端分离的简易书店系统，存在SQL注入、CSRF、XSS、文件上传、SSRF漏洞及其防范方法，编写此系统只为了加深作者对web安全漏洞原理的理解

## 二、先决条件

nginx、php-fpm、mysql、redis

## 三、特性

- 前后端分离，前端Fetch API，中间件nginx，后端接口PHP
  
- cookie、session使用
  
- 各种web安全漏洞及其防范方法
  
- 纯原生，未使用任何框架
  
- redis实现单点登录
  

## 四、安装

git clone该项目

以root身份执行initialize.sh即可完成安装

```shell
git clone https://github.com/pasiphae321/BookstoreSystem.git
sudo ./BookstoreSystem/initialize.sh
```

## 五、demo

登录页面

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/1.png)

主页

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/2.png)

书籍搜索页面