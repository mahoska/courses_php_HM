<?php

interface iData
{
    public function setData($key, $value);
    public function readData($key);
    public function deleteData($key);
}
