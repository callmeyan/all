#目录说明
====================================
此目录存放PHP代码。目前存有模块有：
------------------------------------
## XYRouter
php 简单的伪静态(rewrite)地址重写框架，框架仅仅实现模块编写，可以方面的构造出Restful结构的应用。
### 快速开始
将XYRouter下载到项目中
``git clone https://github.com/callmeyan/all.git`` 
``index.php``编写代码如下：
	require 'XYRouter/Router.php'; 

	Router::getInstance()->initMoudule("modules"); //要初始化的模块文件夹
	try {
		Router::getInstance()->dispatch();     //开始分发请求
	} catch (RouterException $e) {
		Router::getInstance()->showErrorPage(404);    //404错误处理
	} catch (Exception $e) {	
		Router::getInstance()->showErrorPage(500,$e); //500错误处理
	}
模块编写
	class ClassName{
		//正则匹配组地址同意请求 此方法，如果没有此方法则报404
		function __show($param){
			print_r($param);
		}
	}
	Router::getInstance()->addPregRoute("ClassName","^/core/type/(\d+)/page/(\d+)$");   //将地址添加到路由表中（正则）
	Router::getInstance()->addRoute("ClassName","testurl");   //将地址添加到路由表中（一般地址，可自动寻找方法）