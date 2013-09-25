<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'=>'sqlite',
	'DB_NAME'=>'mail.db',
	'DB_PREFIX'=>'think_',
	'DB_CHARSET' => 'utf8',
	'URL_MODEL'          => '2', //URL模式
    'SESSION_AUTO_START' => true, //是否开启session
	'APP_GROUP_LIST' => 'Home,Admin', //项目分组设定
	'DEFAULT_GROUP'  => 'Home', //默认分组
	'URL_HTML_SUFFIX' => '.html',
	'TMPL_FILE_DEPR' => '/',
	'TMPL_L_DELIM' => '<{',
    'TMPL_R_DELIM' => '}>',
	
);
?>