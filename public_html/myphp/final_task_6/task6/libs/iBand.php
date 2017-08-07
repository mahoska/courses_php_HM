<?php

interface iBand
{
    public function getName();
    public function getGenre();
    public function addMusician(iMusician $obj);
    public function getMusician();
}
