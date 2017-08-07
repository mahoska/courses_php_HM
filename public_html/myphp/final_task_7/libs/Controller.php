<?php
class Controller
{
    use AuxiliaryFunctionTrait;

    private $model;
    private $view;
    private $dataMail;
  

    public function __construct()
    {       
        $this->model = new Model();
        $this->view = new View(TEMPLATE);  
        $this->ifSend = false;

                
        if(!is_null($this->requestPost('data')))
        {   
            $this->dataMail = $this->requestPost('data');

            $this->pageSendMail();
        }
        else
        {
            $this->pageDefault();   
        }
            
        $this->view->templateRender();          
    }   
        
    private function pageSendMail()
    {
        if($this->model->checkForm($this->dataMail) === true)
        {
            $this->model->sendEmail();
        }
        $mArray = $this->model->getArray();     
        $this->view->addToReplace($mArray); 
    }   
                
    private function pageDefault()
    {   
        $mArray = $this->model->getArray();      
        $this->view->addToReplace($mArray);             
    }      
    
}

