![file](https://www.emperinter.info/wp-content/uploads/2019/08/1565886091-image-1565886086031.png)
# 一、缘由
**自己最近学完PHP和Mysql，就尝试写了一个留言本，但还有很多不好和错误的地方，欢迎大家多多指导!**

## [项目地址/GITHUB](https://github.com/emperinter/MessageBoard)
## [项目目前demo](https://www.emperinter.cf)

# 二、配置步骤

## 1.首先安装服务器环境

- lnmp或lamp

**[lnmp官网](https://lnmp.org/)**

具体就不聊了，详情见**[WORDPRESS安装教程](https://www.emperinter.info/2018/09/06/%e6%90%ad%e5%bb%bawordpress%e5%8d%9a%e5%ae%a2/)**

> 注意记住填入数据库用户名和密码等等类似的东西

- 宝塔面板

## 2.配置服务器数据库

- 进入数据库后台，按提示输入密码，安装lnmp的时候已经有了
 ``` SHELL
mysql
```

- 创建数据库**notebook**
``` SQL
create database notebook;
```

- 选择数据库**notebook**
``` SQL
use notebook;
```
- 创建数据表**user**
``` SQL
CREATE TABLE IF NOT EXISTS user (
userid int(32) NOT NULL AUTO_INCREMENT,
username varchar(64) NOT NULL,
password varchar(64) NOT NULL,
createtime datetime NOT NULL,
createip varchar(32) NOT NULL,
PRIMARY KEY (userid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
- 创建数据表**note**
``` SQL
CREATE TABLE IF NOT EXISTS note (
noteid int(32) NOT NULL  AUTO_INCREMENT,
username varchar(64) NOT NULL,
note longtext NOT NULL,
date datetime NOT NULL,
PRIMARY KEY (noteid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

## 3.安装
- ### 域名购买
##### [推荐购买网站---英文网站/支持支付宝/价格我感觉比较透明且便宜](https://www.namesilo.com/pricing?rid=415d732iq)

 优惠代码：（可节省1美刀） 
> #### emperinter

<div align="center">
<a href="http://www.namesilo.com/?rid=415d732iq"><img src="http://www.namesilo.com/affiliate/banner_gen.php?aid=415d732iq&bid=53" style="border:0;"></a>
</div>

- ### CDN/域名解析
##### [CloudFlare](https://dash.cloudflare.com)
> 有免费的CDN支持，而且可以隐藏自己的服务器IP，还支持很多的功能，大家慢慢探索，但如果英语不好的话，也可能费点事！


## 4.服务器安装/配置
- 服务器配置
``` SHELL
lnmp vhost add
```
和WordPress安装类似，但在选择**是否创建数据库的时候，选择不创建**

参考：[搭建WordPress博客](https://www.emperinter.info/2018/09/06/%e6%90%ad%e5%bb%bawordpress%e5%8d%9a%e5%ae%a2/)

- 获取我[Github上面的代码](https://github.com/emperinter/MessageBoard)
```
git clone git@github.com:emperinter/MessageBoard.git
```
如**服务器未安装GIT，请参考[Git使用教程](https://www.emperinter.info/2018/12/03/github/)**

- 修改config.php(**数据库配置文件**)
``` PHP
<?php
define('DB_HOST','localhost');                 //一般不改
define('DB_USER','YourUserName');                         //mysql用户名，一般不改
define('DB_PWD','YourPasword');          //mysql数据库密码
define('DB_NAME','notebook');        //我们创建的数据库
define('DB_CHARSET','utf8');         // 编码格式
?>
```


# 三、版权注意

> 目前用的框架是Bootstrap,以前用的EasyUI**应该给全部替换了**，这里还用到了jQuery,以及引入了第三方Markdown,如需使用请注意符合其使用条例！



