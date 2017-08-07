<?php

Trait AuxiliaryFunctionTrait
{
    public function requestPost($key, $default = null)
    {
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
}
