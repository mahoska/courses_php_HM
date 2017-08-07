<?php
class Model
{ 
    private $data;
    private $error;
    private $ifSend;

    public function __construct()
   {
       $this->error = null;
       $this->ifSend = null;
   }
    
    public function getArray()
   {    
        if (!is_null($this->error))
            return array(
                '%TITLE%'=>'Contact Form',
                '%ERRORS%'=>$this->error, 
                '%FORMDATA%'=>$this->data,
                '%SUCCESS%'=>'fail');
        
        else if(!is_null($this->ifSend))
        {
            if($this->ifSend)
                 return array(
                     '%TITLE%'=>'Contact Form', 
                     '%ERRORS%'=>'Your email was successfully sent', 
                     '%FORMDATA%'=> array(), 
                     '%SUCCESS%'=>'success');
             else 
                  return array(
                      '%TITLE%'=>'Contact Form',
                      '%ERRORS%'=>'Unfortunately, the letter was not sent. Try again later',
                      '%FORMDATA%'=> array(),
                      '%SUCCESS%'=>'success');  
        }
           
        
        return array(
            '%TITLE%'=>'Contact Form',
            '%ERRORS%'=>'fill the fields',
            '%FORMDATA%'=> array(),
            '%SUCCESS%'=>'fail'); 
   }
    
    public function checkForm($formData)
    {
        $this->data = $formData;

         if(trim( $this->data['emailTo'])=='' || 
            trim( $this->data['fullname'])=='' || 
            trim($this->data['subject']) == 'null' || 
            trim( $this->data['message'])=='')
        {
            $this->error = 'not all fields are filled';
            return false;
        }    
        
        if(strlen(trim( $this->data['fullname']))<3)
        {
            $this->error = 'full name must be at least 4 characters';
            return false;
        }
        
        //--проверка корректности email
        $this->data['emailTo'] = trim($this->data['emailTo']);     
        $uncorrect_symbol = array(' ',',', ':', ';', '!', '#', '%', '*', '(',
            ')', '=', '+', '{', '}', '[', ']', '"',  '/', '\\', '|' );
        for($i = 0, $len = strlen($this->data['emailTo']); $i < $len;  $i++){
            foreach($uncorrect_symbol as $symbol){
                if($this->data['emailTo'][$i] == $symbol){
                    $this->error = 'uncorrect_symbol in email';
                    return false;
                }
            }
        }
        $email = explode('@',$this->data['emailTo']);
        if(count($email)!=2 || strlen($email[0])<4){
             $this->error = 'email must contain @ and user_part contain more than 4 symbol';
            return false;
        }
        $user_part = explode('.',$email[0]);
        if(strlen($user_part[count($user_part)-1])<2){
             $this->error = 'Last part of the user_name must contain more than 2 symbol';
            return false;
        }
            
        $post_coord = explode('.',$email[1]);
        $len_last_part_coord = strlen($post_coord[count($post_coord)-1]);
        if(count($post_coord)<2 || !($len_last_part_coord>=2 && $len_last_part_coord<=4)){
             $this->error = 'domen must contain more than 2 parts and<br>'
                     . ' last part of the domen must contain 2-4 symbols';
            return false; 
        }
        for($i = 0; $i<$len_last_part_coord; $i++){
                if(is_int($post_coord[count($post_coord)-1][$i])){
                    $this->error = 'last part of the post_coordination can"t contain digits ';
                    return false;
                }
        }
        
         
        return true;
             
    }
   
    public function sendEmail()
    {
        $fio =$this->data['fullname'];
        $keysubject = $this->data['subject'];
        if($keysubject == 'order') $subject = 'Specification by order';
        else if($keysubject == 'question') $subject = 'Question about the product';
        else if($keysubject == 'opt') $subject = 'Wholesale purchase';
        $message = $this->data['message'];
        $email = $this->data['emailTo'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $dateSend = date("m.d.y  H:i:s");
        
        $messageSend = "
          You have sent a letter:
          ----------------------\n
           FullName: $fio\n
           E-mail: $email\n
           Subject: $subject\n\n
          Message:
          ----------------------\n
          $message\n
          ----------------------\n  
          IP: $ip\n
          Date send: $dateSend\n 
           ";
        $to = DEFAULT_EMAIL;
        $from = $email;
        $subject  = "=?utf-8?=B?".base64_encode($subject)."?=";
        $headers = "FROM: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
       
        if(mail($to, $subject, $messageSend, $headers))
             $this->ifSend = true;
    }   
    
 
}

/*
 * Требования к email:
    Адрес должен содержать специальный символ "@", который отделяет имя пользователя почтовой системы от доменного имени;
    -Адрес не должен содержать символов "пробелов", ",", ":", ";", "!", "#", "%", "*", "(", ")", "=", "+", "{", "}", "[", "]/", """, "'", "/", "\" и "|";
    -Адрес должен состоять только из латинских символов;
    Так как в Интернете не существует компьютеров имеющих доменные имена первого уровня, то после символа "@" должна быть как минимум одна ".";
    После последней точки должно быть не менее 2-х и не более 4-х символов, причем наличие цифр не допускается;
    Между последней точкой и символом "@" должно быть не менее 2-х символов
    Слева от "@" должно быть не менее четырех символов.
 * 
 *  //--альтернативная проверка корректности email
        //[a-z0-9][a-z0-9\.-_]*[a-z0-9]+@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+/i
        //if (!preg_match("/^[-0-9a-z_\.]+@[-0-9a-z_^\.]+\.[a-z]{2,6}$/i", $this->email))
 */