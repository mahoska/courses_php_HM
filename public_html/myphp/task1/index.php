<?php
session_start();
include ('config.php');
include ('libs/function.php');

$files =[];
$resUpl =[];

if($_FILES)
{
    $data = $_FILES['data'];
    $resUpl = uploadFiles($data);
    if ($resUpl===false)setFlash(DIR_NOT_FOUND,'fail');
    else
        $resUpl['count']==0 ? setFlash(ERROR_DOWNLOAD_FILE,'fail') : setFlash(SACCESS_DOWNLOAD_FILE) ;
}
else
{
     setFlash(ERROR_SELECT,'fail');
}


if (requestPost('del_file'))
{
    $delFile = requestPost('del_file');
    if(deleteFile($delFile))
        setFlash($delFile." - ".SACCESS_DEL_FILE);
    else
        setFlash(ERROR_DEL_FILE,'fail'); 
}

$flashMessage = getFlash();

$flag = readDirectory($files);
if(!$flag)  setFlash(DIR_NOT_FOUND,'fail');

include ('templates/index.php');
