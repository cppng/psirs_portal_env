<?php


class Db2 extends Db{
 
 


    public function __construct(){

        $this->host = "35.170.84.126";
        $this->database = "psirs_portal";
        $this->username = "root2";
        $this->password = "duffHat@Zrc8";
        $this->log_tag = "Db2";
    }

    public function insert_fresh_rows($table, $rows){ 
        

            foreach($rows as $row){
                unset($row['id']);
                unset($row['supplier']);
                unset($row['is_company']);
                unset($row['customer']);
                unset($row['employee']);
                $query = $this->array_to_query($row, "users");
             
               
                mysqli_query($this->get_connection(), $query) or $this->log(mysqli_error($this->get_connection()));

            }
 

        $this->save_last_update_time(); 
 
    }


    private function array_to_query($insData, $table){

        foreach($insData as $key => $value){

            if(empty($insData[$key])){
                unset($insData[$key]);
            }
            else if(is_string($insData[$key])){

                $insData[$key] = "\"". $insData[$key]. "\"";
            }

            
        }

        $query= "INSERT INTO $table ( " . implode(', ',array_keys($insData)) . ") VALUES (" . implode(', ',array_values($insData)) . ");";

        return $query;
    }


    public function save_last_update_time(){ 

        $date = date("d-m-Y H:i:s.u");
        $query  = "UPDATE pacifier set last_update='$date'";

        $connection = $this->get_connection(); 

        $result =  mysqli_query($connection, $query) or $this->log(mysqli_error($connection)); 

    }


    public function get_entries_since($table_name, $date_column, $date){

        $query = "SELECT * FROM $table_name WHERE  $date_column > '$date' ORDER BY $date_column ";
 
        $result =  mysqli_query($this->get_connection(), $query) or die(mysqli_error($this->get_connection()));
        
        $rows = [];

        while ($row = mysqli_fetch_array($result)) {
            
            if($row!=null){
                 $rows[] = $row;
            }
          }
  

        return $rows;

    }

    public function get_last_sync_date(){

        $query = "SELECT last_update FROM pacifier";
        $result = mysqli_query($this->get_connection(), $query);

        $rows = [];

        while ($row = mysqli_fetch_row($result)) {
            
            if($row!=null){
                 $rows[] = $row;
            }
          }
 

        return $rows[0][0];


    }


    public function get_connection(){

        if($this->connection == null){ 

            $connection = mysqli_connect($this->host, $this->username, $this->password, $this->database) or die(mysqli_error($connection));

            $this->connection = $connection;
        }

        return $this->connection;
    } 
  
 
}