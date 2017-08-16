<?php

 function requestPost($key, $default="")
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}
