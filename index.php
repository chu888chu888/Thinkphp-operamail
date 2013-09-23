<?php
/**
 *
 * index(入口文件)
 *
 * @package         zengde
 * @author          zengde <vzdmj1988@163.com>
 * @copyright       Copyright (c) 20012-2013  (http://www.zengde.org)
 * @version         v2.1 2012-08-18 $
 */

header("Content-type: text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//定义项目名称和路径
define('APP_NAME', './operamail');
define('APP_PATH', 'operamail/');
define('APP_LANG', true);
//开启调试模式
define('APP_DEBUG',true);
// 加载框架入口文件
require('ThinkPHP/ThinkPHP.php');
?>
