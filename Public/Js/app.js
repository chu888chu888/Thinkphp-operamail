function getYearWeek(date){
	var date2=new Date(date.getFullYear(), 0, 1);
	var day1=date.getDay();
	if(day1==0) day1=7;
	var day2=date2.getDay();
	if(day2==0) day2=7;
	d = Math.round((date.getTime() - date2.getTime()+(day2-day1)*(24*60*60*1000)) / 86400000);  
	return Math.ceil(d /7); 
}

function simpletemplate(template){
	str=template.replace(/\{\$([^\{]+)\}/g,function(match,key){
		eval('value = '+key);
		return ( value !== undefined) ? ''+value :'';

	})
	return str
}
degree=0
function rotateanim(){
	degree+=30
	$('.icon-reload-anim').css('WebkitTransform','rotate(' + degree + 'deg)')
	if(degree>=360)
		degree=0	
	t=setTimeout('rotateanim()',100)
}

$(document).ready(function(){
	$('a.rssreada').click(function(){
		obj=$(this)
		$('a.rssreada').parents('li').removeClass('selected')
		$(this).parents('li').addClass('selected')
		id=$(this).data('id')
		lastread=$(this).data('lastread')
		url='Index/get_list.html?id='+id
		$.get(url,function(json){
			info=json.info
			if(info){
				var d=new Date()
				var weekday=['周日','周一','周二','周三','周四','周五','周六']
				var months=['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月']
				day=d.getDay()
				mon=d.getMonth()
				year=d.getFullYear()
				time=d.getTime()
				week=getYearWeek(d)
				curday=curmon=curweek=curyear=curearly=-1
				strs={'daystr':'','weekstr':'','monstr':'','yearstr':'','earlystr':''}
				temp="<li class='{$arclass} {$selected}' title='{$info}' data-id='{$arcid}'><span class='arctitle'><h3>{$title}</h3></span><span class='arcuser'>{$author}</span><span class='arctime fr'>{$temptime}</span></li>"
				$.each(info,function(idx,val){
					d2=new Date(val.pubdate*1000)
					day2=d2.getDay()
					date2=d2.getDate()
					mon2=d2.getMonth()
					year2=d2.getFullYear()
					week2=getYearWeek(d2)
					title=val.title
					info=title+'\r\n日期：'+d2.toLocaleString()
					author=val.author
					arclass=(val.isread=='0')? 'unseen':''
					selected=(idx==0&&lastread=='0')||(lastread==val.id)? 'selected':''
					arcid=val.id
					if(year2==year&&week2==week){
						if(day==day2)
							temptime=d2.getHours()+':'+d2.getMinutes()
						else
							temptime=weekday[day2]+' '+d2.getHours()+':'+d2.getMinutes()
						key='daystr'
						if(curday==-1){
							strs[key]+='<div class="arcdate">'+weekday[day2]+'</div><ul class="arclis">'
							curday=day2
						}else if(curday!=day2){
							strs[key]+='</ul></div>'
							strs[key]+='<div class="arcdate">'+weekday[day2]+'</div><ul class="arclis">'
							curday=day2
						}
					}else if(year2==year&&(week2+1)==week){
						temptime=weekday[day2]+' '+d2.getHours()+':'+d2.getMinutes()
						key='weekstr'
						if(curweek==-1){
							strs[key]+='<div class="arcdate">上周</div><ul class="arclis">'
							curweek=week2
						}
					}else if(year2==year){
						temptime=year2+'/'+mon2+'/'+date2
						key='monstr'
						if(curmon==-1){
							strs[key]+='<div class="arcdate">'+months[mon2]+'</div><ul class="arclis">'
							curmon=mon2
						}else if(curmon!=mon2){
							strs[key]+='</ul></div>'
							strs[key]+='<div class="arcdate">'+months[mon2]+'</div><ul class="arclis">'
							curmon=mon2
						}
					}
					else if(year2+1==year){
						temptime=year2+'/'+mon2+'/'+date2
						key='yearstr'
						if(curyear==-1){
							strs[key]+='<div class="arcdate">'+year2+'</div><ul class="arclis">'
							curyear=year2
						}
					}
					else{
						temptime=year2+'/'+mon2+'/'+date2
						key='earlystr'
						if(curearly==-1){
							strs[key]+='<div class="arcdate">之前的</div><ul class="arclis">'
							curearly=1
						}
					}
					strs[key]+=simpletemplate(temp)
				})
				for(i in strs){
					if(strs[i]!='')
						strs[i]+='</ul></div>'
				}
				html=strs.daystr+strs.weekstr+strs.monstr+strs.yearstr+strs.earlystr
				$('.arcs').html(html)
				$('.arclis li.selected').trigger('click')
			}
		})
	})
	$('.arclis li').live('click',function(){
		$('.arclis li').removeClass('selected')
		$(this).addClass('selected')
		$(this).removeClass('unseen')
		arcid=$(this).data('id')
		url='Index/view.html?id='+arcid
		$.get(url,function(json){
			info=json.info
			$('.ltitle h1').html(info.title)
			$('.lauthor').html(info.author)
			$('.time').html(new Date(info.pubdate*1000).toLocaleString())
			$('.main p:first-child').html(info.content)
			$('.readetail').attr('href',info.link)
		})
	})
	rotateanim()
	$('a.rssreada').eq(0).trigger('click')
})

