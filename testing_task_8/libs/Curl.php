<?php

define('ERROR_CURL','Website not available');

class Curl
{
    private $page;
    private $ch;
    private $url;
    private $dataSearch;
    
     public function __construct($url)
    {
        $this->url = $url;
        // Initialize cURL and set the address
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        
        $this->dataSearch = [];
    }

    public function __destruct()
    {
        // Close the connection
	curl_close($this->ch);
    }
    
    public function setPage()
    {
//        $headers = [
//                'authority:www.google.com.ua',
//                 'method:POST',
//                'path:/gen_204?atyp=i&ct=slh&cad=&ei=YI1_Wf75KMShUcCPmtgB&s=2&v=2&pv=0.18980989703025086&me=12:‎1501531489424,V,0,0,0,0:51,U,51:0,V,0,0,1366,163:5743,e,H&zx=‎1501531495218',
//                'scheme:http',
//                'accept:*/*',
//                'accept-language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
//                'cache-control:max-age=0',
//                'content-length:0',
//                'content-type:text/html;charset=UTF-8',
//                'cookie:XDEBUG_SESSION=PHPSTORM; NID=108=s-tO0gCk1SxV8ZyBJVxwpGAiM0BQq2OYXX9XAxcCl46CrttFteJXwVCZzqwZDduk2gTeUGjPUWp26bKCrsiVTSBQh5GXrGlJ9_9SsH5Gplqd9BqOR6hS3B3L2vP3jDHdmYAeLwTy4pGlk_i_Hmqzod8bXDTYmAk1zcbDuhk3PZ__EXSIPz37gGmKpcB64zM8EKzmMJYb6EHLeCDZhakJ1G7mAAyatYAcic4IVmM; DV=U0l6_aZ4IlMt4Ga-ULf03c-TNASk2VW48WNVQ7njPqIwAQA; UULE=a+cm9sZToxIHByb2R1Y2VyOjEyIHByb3ZlbmFuY2U6NiB0aW1lc3RhbXA6MTUwMTUzMTQ4ODUyNzAwMCBsYXRsbmd7bGF0aXR1ZGVfZTc6NDY5NjYzODM1IGxvbmdpdHVkZV9lNzozMjAyMTQyOTl9IHJhZGl1czozMDM4MA==',
//                'origin:http://www.google.com.ua',
//                'referer:http://www.google.com.ua/',
//                'user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36',
//                'x-chrome-uma-enabled:1',
//                'x-client-data:CI+2yQEIorbJAQjEtskBCPqcygEIqZ3KAQ=='
//            ];
        
            
       
                // Set options
		//curl_setopt ($this->ch, CURLOPT_HTTPHEADER, $headers);
                
                // don't include http headers in the result
		curl_setopt($this->ch, CURLOPT_HEADER, false);
                //include the body of an http document in the result
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
                // Get the answer
		$this->page = curl_exec($this->ch);
		if (!$this->page = curl_exec($this->ch))
			throw new Exception(ERROR_CURL);
               
                
                
		return $this;
    }
    
    public function getPage()
    {
        return $this->page;
    }
    
    
    
    public function getEditedPage()
    {
        //Create an object of class domDocument
        $dom = new DOMDocument();
        //Load into it html code
        @$dom->loadHTML($this->page);
        $xpath = new DomXPath($dom);
        $result = $xpath->query(".//div[@class='rc']");
        var_dump($result);
        //$result = $xpath->query("//*[contains(@class, 'rc')]");
        
        
        
        for($i = 0, $length = $result->length; $i < $length; $i++)
        {
            $this->dataSearch[$i]=[
                'name'=>$result->item($i)->firstChild->firstChild->nodeValue,
                'link'=>$result->item($i)->firstChild->firstChild->getAttribute('href'),
                'description'=>$result->item($i)->getElementsByTagName('span')->item(1)->nodeValue
            ];
             
        }
        
        
       
       
        var_dump($this->dataSearch);
        
        return $this->dataSearch;
    }
   
    
}



