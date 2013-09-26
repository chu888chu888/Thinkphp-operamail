<?php
/*
 *    This class read and write and RSS
 *    to a file.
 */
class gRSS {
    var $rssArr; /* RSS parsed @Array */
    var $flag;
    var $size;
    var $currentTag;

    function iniParse() {
        unset($this->rssArr);
        /* Basic @ structure*/
        $this->rssArray['channel']=array();
        $this->rssArr['channel']['encoding'] = 'UTF-8';
        $this->rssArray['item']=array();
    }

    /*
    **    This function transform an RSS2 text into 
    **    an Array.
    */    
    function parse($txt) {
        $this->size = 0; /**/
        $this->iniParse();

        $this->pzXML = xml_parser_create();
        xml_parser_set_option($this->pzXML,XML_OPTION_CASE_FOLDING,true);
        xml_set_element_handler($this->pzXML, array($this,"startTag"),array($this,"endTag") );
        xml_set_character_data_handler($this->pzXML,array($this,"dataHandling") );
        xml_parse($this->pzXML,$txt, true);
        xml_parser_free($this->pzXML);
		$this->cleanXML($this->rssArr);
		$tmp = &$this->rssArr;
		$this->size++; /* Increment to one the size, because the first one is the RSS information */
        return isset($tmp['channel']) && isset($tmp['item']) && is_array($tmp['item']);
    }
    
    /*
    **    This function transform an Array into a RSS2
    **    file.
    */
    function unParse() {
        $tmp = $this->rssArr['channel'];
        $this->safeXML($tmp);
        $r[] = '<?xml version="1.0" encoding="'.(isset($tmp['encoding']) ? $tmp['encoding'] : 'UTF-8').'"?>';
        $r[] = '<!-- Powered by Cesar D. Rodas\' gFeed (http://cesars.users.phpclasses.org/gfeed/) -->';
        $r[] = '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/">';
        $r[] = "\t<channel>";
        $r[] = "\t\t<title>".$tmp['title']."</title>";
        $r[] = "\t\t<link>".$tmp['link']."</link>";
        $r[] = "\t\t<generator>".$tmp['generator']."</generator>";
        $r[] = "\t\t<pubdate>".$tmp['pubdate']."</pubdate>";
        $r[] = "\t\t<description>".$tmp['description']."</description>";
        
        foreach($this->rssArr['item'] as $k => $y) {
            $this->safeXML($y);
            $r[] = "\t\t<item>";
            $r[] = "\t\t\t<title>".$y['title']."</title>";
            $r[] = "\t\t\t<author>".$y['author']."</author>";
            $r[] = "\t\t\t<pubdate>".$y['pubdate']."</pubdate>";
            $r[] = "\t\t\t<link>".$y['link']."</link>";
            $r[] = "\t\t\t<description><![CDATA[".$y['description']."]]></description>";    
            $r[] = "\t\t</item>";
        }
        $r[] = "\t</channel>";
        $r[] = "</rss>";
        
        return implode("\r\n",$r);     
    }
    /**    
    **    Auxiliars functinon used for RSS 2 Array
    */
    function safeXML(&$arr) {
        foreach($arr as  $k => $y) {
            if (is_array($k)) $this->safeXML($y);
            else $arr[$k] = /*htmlentities*/($y);
        }
    }
    function cleanXML(&$array) {
        if (!is_array($array)) return false;
        foreach ($array as $k => $v) {
            if (trim($k)=='') unset($array[$k]);
            
            else if (is_array($v)) $this->cleanXML($array[$k]);
            else { 
                $v = trim($v);
                /*
                **    Show HTML tags if there is.
                */
                $v = preg_replace("/<(.*?)>/e","'<'.stripslashes(trim(strtoupper('\\1'))).'>'", $v);
                $array[$k] = str_replace(' & ','&', $v);
            
            }
        }
        return true;
        
    }
    function startTag(&$parser,&$name,&$attribs){ 
        if($name){    
            switch(strtolower($name)){
                case "rss":
                    if ( isset($attribs['ENCODING']) ){
                        $this->rssArr['channel']['encoding'] = $attribs['ENCODING'];
                        break;
                    }
                    break;
                case "channel":
                    $this->flag=channel;
                    break;
                case "image":
                    $this->flag=image;
                    break;
                case "entry":
                case "item":
                    $this->flag=item;
                    $this->size++;

                    break;    
                case "link":
                    if ( isset($attribs['REL']) && $attribs['REL'] == 'alternate' && $attribs['TYPE'] == 'text/html'){
                        $this->rssArr["item"][$this->size]['link']=$attribs['HREF'];
                        break;
                    }
                default:
                    $this->currentTag=trim(strtolower($name));
                    break;
            }
        }
    }
    function endTag(&$parser,&$name){ 
        $this->currentTag="";
    }
    function dataHandling(&$parser,&$data){ 
        switch ($this->flag) {
            case channel:
                if(isset($this->rssArr["channel"][$this->currentTag])){
                    $this->rssArr["channel"][$this->currentTag].=$data;
                 }else{
                    $this->rssArr["channel"][$this->currentTag]=$data;
                }
                break;
            case item:
                if(isset($this->rssArr["item"][$this->size][$this->currentTag])){
                    $this->rssArr["item"][$this->size][$this->currentTag].=' '.$data;           
                }else{
                    $this->rssArr["item"][$this->size][$this->currentTag]=$data;
                }
                break;
            case image:
                if(isset($this->rssArr["image"][$this->currentTag])){
                    $this->rssArr["image"][$this->currentTag].=$data;
                }else{
                    $this->rssArr["image"][$this->currentTag]=$data;
                }
                break;
            }
    }


}

class RssReader extends gRSS{
	public $rssTagsName = array (
		'title' => array('title'),
		'author' => array('author','dc:creator','name'),
		'pubdate' => array('published','pubdate'),
		'link' => array('link','guid'),
		'content' => array('content','description')
	);
	public $path;
	public $content;
	public $position;
	
	public function __construct($path=''){
		$this->position=0;
		$this->path=$path;
	}

	public function parseUrl($url=''){
		$path=empty($url)? $this->path:$url;
		$data=file_get_contents($path);
		$this->parse($data);
	}
	
	public function parseString($data){
		$this->parse($data);
	}
	
    public function getRssVar($varName, $item) {
        if (!is_array($item)) return false;
        if ( isset($this->rssTagsName[$varName]) ) {
            foreach($this->rssTagsName[$varName] as $v) 
                if ( isset($item[$v]) ) return $item[$v];
            return false;
        }
        return isset($item[$varName]) ? $item[$varName] : false;
    }
	
	public function read(){
		if ($this->position == 0) {
			$tmp =$this->rssArr['channel'];
		}else
			$tmp =$this->rssArr['item'][ $this->position ];
		foreach($this->rssTagsName as $k=>$v){
			$arr[$k]=$this->getRssVar($k, $tmp);
		}
		$this->position++;
		return $arr;
	}
	
	public function next(){
		return $this->position < $this->size;
	}
	
	public function skip(){
		$this->position++;
	}
}

?>