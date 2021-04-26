<?php

class DB{
 
    protected $host;
    protected $database;
    protected $username;
    protected $password;

    protected $log_tag;
    protected $connection;
  


    public function log($word){
        $date = date("d-m-Y H:i:sa");
        echo "{$this->log_tag} $date : " . $word;
        echo "<p> </p>";

    } 

 

  
    public function get_last_sync_date(){

        $query = "SELECT last_update FROM pacifier";
        $result =  pg_query($this->get_connection(), $query);

        $rows = [];

        while ($row = pg_fetch_row($result)) {
            
            if($row!=null){
                 $rows[] = $row;
            }
          }
 

        return $rows[0][0];


    }


    public function get_entries_since($table_name, $date_column, $date){

        $query = "SELECT * FROM $table_name WHERE  $date_column > '$date' ORDER BY $date_column ";
 
        $result =  pg_query($this->get_connection(), $query);
        
        $rows = [];

        while ($row = pg_fetch_assoc($result)) {
            
            if($row!=null){
                 $rows[] = $row;
            }
          }
  

        return $rows;

    }
 

    public function insert_fresh_rows($table, $rows){ 
        
        pg_query("BEGIN");
 
            foreach($rows as $row){
                unset($row['id']);
                $result =  pg_insert($this->get_connection(), "res_partner", $row);  

            }

        pg_query("COMMIT");  

        $this->save_last_update_time(); 
 
    }


    public function save_last_update_time(){ 

        $date = date("Y-m-d h:i:s"); 
        $query  = "UPDATE pacifier set last_update='$date'";

        $connection = $this->get_connection(); 

        $result =  pg_query($this->get_connection(), $query); 

    }



    public function get_connection(){

        if($this->connection == null){
            $this->connection = pg_connect("host={$this->host} dbname={$this->database} user={$this->username} password={$this->password}");
        }
         
        
        return $this->connection;
    }



    public function close_connection(){

       
        $this->connection = null;
        return  pg_close($this->connection);
    }



}