<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='__PUBLIC__/Css/base.css' rel='stylesheet' />
</head>
<body>
<div class='left sidebar'>
	<div class='toolbary'>
		<span class='holdery'></span>
		<span class='icontols'><i class='icon icon-bookmark'></i></span>
		<span class='icontols'><i class='icon icon-mail icon-mailselected'></i></span>
		<span class='icontols'><i class='icon icon-notes'></i></span>
		<span class='icontols'><i class='icon icon-downloads'></i></span>
		<span class='icontols'><i class='icon icon-history'></i></span>
		<span class='icontols'><i class='icon icon-add'></i></span>
	</div>
</div>
<div class='left mailist'>
	<div class='toolbar'>
		<div class='borderbg'>
			<span class='holder fl'></span>
			<span class='icontols fl'>
				<i class='icon icon-text dropdowndiv'>邮件
					<i class='dropdown'></i>
				</i>
			</span>
			<span class='holder fr'></span>
			<span class='icontols fr'><i class='icon icon-close'></i></span>
		</div>
	</div>
	<div class='border'>
		<div class='toolbar panelbar'>
			<span class='icontols fl'><i class='icon icon-reload' title='更新全部(CTRL+R)'></i></span>
			<span class='icontols fr'>
				<i class='icon icon-config dropdowndiv' title='查看'>
					<i class='dropdown'></i>
				</i>
			</span>
		</div>
		<div class='accordbar'>
			<div class='accordtitle'>网源</div>
			<ul class='rsslis'>
				<?php $__FOR_START_9404__=1;$__FOR_END_9404__=15;for($i=$__FOR_START_9404__;$i < $__FOR_END_9404__;$i+=1){ ?><li <?php if(($i) == "1"): ?>class='selected'<?php endif; ?>>
					<img src='http://qihuailong.com/favicon.ico'>
					<span class='rsstitle'>
						<a href='e' title='Qihuailong(33封未读，共33封)'>Qihuailong™</a>
					</span>
					<span class='rsscount fr'>80</span>
				</li><?php } ?>
			</ul>
			<div class='accordtitle'>标签</div>
		</div>
	</div>
</div>
<div class='left arclist'>
	<div class='toolbar'>
		<div class='borderbg'>
			<span class='holder fl'></span>
			<span class='search fl'>
				<form action=''>
					<input class='searchtxt' type='text' name='' placeholder='搜索文章' />
					<input type='button' class='searchdrop' />
				</form>
			</span>
			<span class='icontols fl'><i class='icon icon-reload' title='更新(CTRL+R)'></i></span>
			<span class='holder fr'></span>
			<span class='icontols fr'>
				<i class='icon icon-listsort dropdowndiv' title='此视图的设置：'>
					<i class='dropdown'></i>
				</i>
			</span>
		</div>
	</div>
	<div class='arcs'>
		<div class='arcdate'>昨天</div>
		<ul class='arclis'>
			<li>
				<span class='arctitle'><h3>高清精美壁纸：2013年10月桌面日历壁纸免费下载 - 梦想天空（山边小溪）</h3></span>
				<span class='arcuser'>梦想天空（山边小溪）</span>
				<span class='arctime fr'>周日 14:10</span>
			</li>
		</ul>
	</div>
</div>
<div class='left content'>
	<div class='toolbar'>
		<span class='holder fl'></span>
		<span class='icontols fl'><i class='icon icon-read' title='已阅读(K)'></i></span>
		<span class='icontols fl'>
			<i class='icon icon-delete dropdowndiv' title='删除'>
				<i class='dropdown'></i>
			</i>
		</span>
		<span class='holder fr'></span>
		<span class='icontols fr'>
			<i class='icon icon-config dropdowndiv' title='邮件的默认设置'>
				<i class='dropdown'></i>
			</i>
		</span>
		
	</div>
	<div class='mcont'>
		<div class='ltitle'>
			<h1>在线字体识别方法 </h1>
			<div class='linfo'>lvtao <span class='time'>2013年8月29日 22:50:22</span></div>
		</div>
	</div>
	<hr>
	<div class='mcont main'>
		<p>
			程序发轻狂，代码阑珊，苹果开发安卓狂！——写给狂热的编程爱好者们 学习iOS应用程序开发已有一段时间，最近稍微闲下来了，正好也想记录一下前阶段的整个学习过程。索性就从最基础的开始，一步一步记录一个最简单的iOS应用从创建到运行的全过程，其中会穿插很多相关知识或是遇到过的问题。
			阅读全文>>
		</p>
		<p><a href='' class='more'>阅读全文</a><p>
	</div>
</div>
</body>
</html>