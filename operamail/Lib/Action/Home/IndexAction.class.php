<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		$nodes=M('RssNode')->select();
		$rss=M('Rss')->where('nodeid=1')->select();
		$this->assign('list',$rss);
		$this->assign('nodes',$nodes);
		$this->display();
    }
	
	public function refresh(){
		if(isset($_GET['nodeid'])){
			$map['id']=$_GET['nodeid'];
		}
		$nodes=M('RssNode')->select();
		foreach($nodes as $k=>$v){
			$url=$v['url'];
			$data=$this->_parseXml($v);
		}
	}
	
	protected function _parseXml($arr){
		$key=md5($arr['url']);
		$nodeid=$arr['id'];
		$cache=F($key);
		if(empty($cache)||time()-$cache['time']>$arr['frequence']){
			$cache=array(
				'time'=>time(),
				'data'=>file_get_contents($arr['url'])
			);
			F($key,$cache);
		}
		$data=$cache['data'];
		$model=M('Rss');
		$history=M('RssHistory');
		import('@.Thirdlib.gFeed');
		$xml=new RssReader();
		$xml->parseString($data);
		$xml->skip();
		
		while($xml->next()){
			$xmldata=$xml->read();
			$map['hash']=md5($xmldata['link']);
			if($tmp=$history->where($map)->find()){
				continue;
			}else{
				$history->add($map);
				$xmldata['pubdate']=strtotime($xmldata['pubdate']);
				$xmldata['nodeid']=$nodeid;
				$model->add($xmldata);
			}
		}
	}
}