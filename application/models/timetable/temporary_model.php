<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

// 作业
include_once 'content_model.php';
class temporary_model extends content_model
{
    function __construct()
    {
        parent::__construct ();
        $this->table = 'fly_temporary';
    }















}