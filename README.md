## 一、简介

该项目是一个用PHP编写的前后端分离的简易书店系统，存在SQL注入、CSRF、XSS、文件上传、SSRF漏洞及其防范方法，编写此系统只为了加深作者对web安全漏洞原理的理解

## 二、环境

ubuntu20.04

## 三、特性

- 前后端分离，前端为异步的Fetch API，中间件nginx处理静态资源，后端为PHP编写的遵循RESTful API规范的接口

- cookie、session使用

- 各种web安全漏洞及其防范方法

- 纯原生，未使用任何框架

- MySQL实现数据存储

- redis实现单点登录

## 四、安装

在ubuntu20.04下git clone该项目

以root身份执行initialize.sh即可完成安装

```shell
git clone https://github.com/pasiphae321/BookstoreSystem.git
sudo bash ./BookstoreSystem/initialize.sh
```

## 五、漏洞位置

### SQL注入

v1/book.php

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/4.png)

### CSRF

v1/user/password.php

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/5.png)

### XSS

前后端分离后因为现代浏览器的安全策略，很难有XSS漏洞，故只能保留前后端分离前的XSS漏洞

#### 反射型XSS

old/book_search.php

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/6.png)

#### 存储型XSS

old/user_suggest.php

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/7.png)

### 文件上传

v1/user/avatar.php

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/8.png)

### SSRF

old/ssrf.php

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/9.png)

## 六、demo

登录页面

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/1.png)

主页

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/2.png)

书籍搜索页面

![这里有一个图片](https://callisto.oss-cn-chengdu.aliyuncs.com/images/bookstore_system/3.png)