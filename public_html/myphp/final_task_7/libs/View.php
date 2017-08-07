<?php
class View
{
    private $forRender;//array
    private $file;//template

    public function __construct($template)
    {       
          $this->file = file_get_contents($template);
    }

    public function addToReplace($mArray)
    {
      foreach($mArray as $key=>$val)
       {
            $this->forRender[$key] = $val;
       }
    }

    public function templateRender()
    {
        foreach($this->forRender as $key=>$val)
        {
            if($key == '%FORMDATA%')
            {
                if(!empty($val))
                {
                    foreach ($val as $datakey =>$dataval)
                    {
                        $key = '%'.strtoupper($datakey).'%';
                        $val = $dataval;
                        if($datakey === 'subject')
                        {
                            $selkey = '%'.strtoupper($dataval).'%';
                            $this->file = str_replace($selkey, 'selected', $this->file);
                        }

                        $this->file = str_replace($key, $val, $this->file);
                    }
                }
                else 
                {
                    $this->file = str_replace('%FULLNAME%', '', $this->file);
                    $this->file = str_replace('%DEFAULT%', 'selected', $this->file);
                    $this->file = str_replace('%EMAILTO%', '', $this->file);
                    $this->file = str_replace('%MESSAGE%', '', $this->file);                  
                }
            }
            else
                $this->file = str_replace($key, $val, $this->file);
        }                                                   
        echo $this->file;
    }
}

