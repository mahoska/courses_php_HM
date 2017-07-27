<?php
function requestPost($key, $default=null)
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

//function redirect($to)
//{
//    header('Location:'.${to});
//    exit();
//}

function setFlash($message,$default='success')
{
    $_SESSION[FLASH_KEY] = ['status' => $default, 'message' => $message];
}


function getFlash()
{
    if (!isset($_SESSION[FLASH_KEY])) {
        return null;
    }
    
    $flash = $_SESSION[FLASH_KEY];
    unset($_SESSION[FLASH_KEY]);
    
    return $flash;
}


function readDirectory(&$to)
{
    if(is_dir(DIR_PATH))
    {
        $dir = opendir(DIR_PATH);

            while(($filename=readdir($dir))!==false){
                if(!is_dir($filename)) { 
                    $filesize = getFileSize(DIR_PATH.$filename);
                    $to[]=['filename'=>$filename, 'filesize'=>$filesize];
                }
            }
            closedir($dir);

        return  true;
    } 
    else 
        return false;
}

function  getFileSize($filename)
{
    $filesize = filesize($filename);
    // if > 1Kb
    if($filesize > 1024)
    {
        $filesize = ($filesize/1024);
        // if > 1MB
        if($filesize > 1024)
        {
            $filesize = ($filesize/1024);
            //if > 1GB
            if($filesize > 1024)
            {
               $filesize = ($filesize/1024);
               $filesize = round($filesize, 1);
               return ['size'=>$filesize, 'units'=>'GB'];       
            }
            else
            {
               $filesize = round($filesize, 1);
               return ['size'=>$filesize, 'units'=>'MB'];    
            }       
        }
        else
        {
            $filesize = round($filesize, 1);
            return ['size'=>$filesize, 'units'=>'Kb'];    
        }  
    }
    else
    {
        $filesize = round($filesize, 1);
        return ['size'=>$filesize, 'units'=>'bites'];   
    }
}

//function if_file_exists($dir,$file){
//    $dir = opendir($dir);
//    if(!$dir)
//        return false;
//    else{
//        while(($filename=readdir($dir))!==false){
//            if(!is_dir($filename) && $filename==$file) return false;
//        }
//        closedir($dir);
//        return  true;
//    }
//}


function uploadFiles($data)
{
    if(is_dir(DIR_PATH))
    {
        $resUpl= [];
        $countUpl = 0;
            for($i=0, $count=count($data['tmp_name']); $i<$count; $i++)
            {
                $isUpload = false;
                $new_file_name = DIR_PATH.$data['name'][$i];
                if(is_uploaded_file($data['tmp_name'][$i]))
                {
                    if(!file_exists($new_file_name))
                    {  
                        if(move_uploaded_file($data['tmp_name'][$i], $new_file_name))
                        {  
                            $isUpload = true;
                            $countUpl++;
                        }
                    }
                }
                $resUpl[] = ['fileName'=>$data['name'][$i],'isUpload'=> $isUpload];
            }

            $res = array(
                'count' => $countUpl,
                'infoUpl' => $resUpl
            );

        return $res;  
    }
    else 
        return false;
}

function deleteFile($del_file)
{
    $old = getcwd();
    if (!(chdir(DIR_PATH))) return false;//Error open path
    if(file_exists($del_file) && is_writable($del_file))
    {
        if (!(unlink($del_file))) return false;//Error Delete File
    }
    else
    {
        chdir($old);
        return false;
    }
    
    chdir($old);
    return true;

}

  
