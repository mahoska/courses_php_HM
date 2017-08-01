<?php

function quotation_marks(&$item, $key, $prefix) 
{
    $item = is_string($item) ? "${prefix}${item}${prefix}" : $item;
}