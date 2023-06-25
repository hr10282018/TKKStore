## 校园二手交易平台





##### 项目详情(包括效果图、技术点等)

```
https://blog.csdn.net/hh123555/article/details/130914963
```



### 前言

##### 学习网址

在做这个项目之前，跟着 Learnku 学习了 Laravel 的中文文档相关知识，还有关于简易的微博、论坛和商城的项目。欢迎大家一起学习交流。

```
https://learnku.com/laravel
```



##### 项目描述

校园二手交易平台，用户可以是卖家或买家。卖家在平台发布商品，买家浏览商品，选择想要的商品进行预定，预定需要卖家回复，同意预定后，生成对应的订单，双方可在线下进行支付交易，最后填写剩余订单的信息，完成订单交易。关于预定和订单的操作，可在个人中心查看，也非常方便用户管理对应的信息。

后台按照用户-权限-角色，管理平台的用户、商品等信息，包括对应的增删改查。



##### 相关技术栈

- laravel 7

- laravel-admin（后台）
- MySQL
- Redis
- jQuery
- CSS(Scss)
- bootstrap
- axios



##### 使用扩展包

- bootstrap

```
composer require laravel/ui:^2.0

php artisan ui bootstrap
```

- 验证码

```
composer require "mews/captcha:~3.0"
```

- 中文语言包

```
composer require "overtrue/laravel-lang:~3.0"
```

- 用户快速切换工具 sudo-su

```
composer require "viacreative/sudo-su:~1.1"
```

laravel-admin 后台

```
composer require encore/laravel-admin:1.7.15 -vvv
```



### 配置

##### 安装

###### composer

```shell
composer install	# php8， update
```

###### 前端依赖

```
SASS_BINARY_SITE=http://npm.taobao.org/mirrors/node-sass yarn
```

###### .env 文件

```
QUEUE_CONNECTION=redis	# 开启 redis 驱动
```



```shell
MAIL_MAILER=smtp
MAIL_HOST=smtp.qq.com
MAIL_PORT=25			# SMTP 服务器端口
MAIL_USERNAME=xxx@qq.com	# 你的QQ
MAIL_PASSWORD=xxx	# 你的授权密码
MAIL_ENCRYPTION=tls		# tls端口
MAIL_FROM_ADDRESS=xxx@qq.com	# 和 MAIL_USERNAME 一致
```

##### 执行数据库迁移

```php
php artisan migrate
php artisan db:seed
```





### 功能模块

#### 用户模块

##### 功能点

- 登录

- [x] 记住我（remember_token）

- 注册

- [x] QQ邮箱验证
- [x] 验证码

- 个人中心

- [x] 我的信息（个人信息、预定信息、评论信息、订购商品、订单信息）
- [x] 我的店铺（发布商品、预定通知、出售订单）

- 编辑资料

- [x] 编辑基本信息（axios 查询，提示信息重复，比如用户名）
- [x] 修改头像
- [x] 修改密码
- [x] 显示设置（可 显示/隐藏 某些个人信息）

- [x] 修改频率：1分钟3次

##### 技术点

- 记住我

- 处理编辑信息

- 处理图片

- QQ邮箱验证



#### 商品模块

##### 功能点

- 最新发布商品

- [x] 提供最近  3天、7天、15天。

- 热门商品

- [x] 热度排名前十的商品

- 商品搜索

- [x] 内容搜索

- [x] 商品状态搜索

- [x] 时间排序
- [x] 价格排序

- 商品分类

- 商品详情

- [x] 计算浏览量

- 发布商品

- [x] 立即发布

- [x] 暂不发布

- 编辑商品

- [x] 编辑

- [x] 查看

- [x] 删除

##### 技术点

- 查询数据优化

- 热门商品计算 和 任务调度

- 计算浏览量

- 商品瀑布流布局



#### 评论模块

##### 功能点

- 评论商品（商品详情页下评论）

- [x] 删除自己评论
- [x] 删除某个或所有评论（如果你是这个商品的发布者，即卖家）



#### 预定模块

##### 功能点

- 预定商品

- [x] 买家 可/不可 预定

- [x] 卖家回复 可/不可 预定
- [x] 买家取消预定

- 消息通知

- [x] 查看消息通知（可跳转对应事件）

##### 技术点

- 处理预定商品

- 消息通知



#### 订单模块

##### 功能点

- 商品订单

- [x] 买家/卖家 取消订单

- [x] 卖家回复订单

- 订单超时

- [x] 延迟任务

- 消息通知

- [x] 查看消息通知

##### 技术点

- 延迟任务



#### 后台管理模块

##### 功能点

- 管理用户

- [x] 用户列表
- [x] 用户详情
- [x] 用户 curd

- 管理商品

- [x] 商品详情
- [x] 商品 curd

- [x] 审核商品

- 管理评论

- [x] 删除评论

- 管理预定

- [x] 预定详情

- 管理订单

- [x] 订单详情
- [x] 修改订单

- 用户角色权限



##### 技术点

使用 Laravel-admin，因为有些界面样式和功能不是我想要的，通过查看相关的源码，进行了部分调整，增加或删除相关功能。



#### 其他功能

平台还有很多其他的功能不再例举，如错误处理页面（403、404等）、执行操作前查询确认数据（避免异常情况）、弹框交互、授权策略等等，增加了系统的健壮性；遵循人机交互原则，保持界面的一致性，体现用户与界面的轻松交互。



