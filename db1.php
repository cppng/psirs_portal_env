<?php


class Db1 extends Db{



    public function __construct(){

        $this->host = "52.53.125.226";
        $this->database = "PSIRS4";
        $this->username = "odoo";
        $this->password = "pwd";
        $this->log_tag = "db1";

    }
}