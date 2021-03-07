<?php


class Db2 extends Db{
 
 


    public function __construct(){

        $this->host = "localhost";
        $this->database = "psirs4";
        $this->username = "postgres";
        $this->password = "test123";
        $this->log_tag = "Db2";
    }

  
 
}