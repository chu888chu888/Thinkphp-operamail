<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
		$nodes=M('RssNode')->select();
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
		$cache=F($key);
		if(empty($cache)||time()-$cache['time']>$arr['frequence']){
			$cache=array(
				'time'=>time(),
				'data'=>file_get_contents($arr['url'])
			);
			F($key,$cache);
		}
		$data=$cache['data'];
		$xml=simplexml_load_string($data);
		var_dump($xml);
		$arr = json_decode(json_encode((array)$xml), TRUE);
		var_dump($arr);
	}
}