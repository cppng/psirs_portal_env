<?php

require("config.php");

require("db.php");
require("db1.php");
require("db2.php");

$tin_table_in_db1 = "res_partner";
$tin_table_in_db2 = "res_partner";


$db1 = new Db1();
$db2 = new Db2();


$last_date_tin_db1 = $db1->get_last_sync_date(); 
$last_date_tin_db2 = $db2->get_last_sync_date();

 
   
$fresh_rows_in_db_1 = $db1->get_entries_since($tin_table_in_db1, "create_date", $last_date_tin_db2 );
$fresh_rows_in_db_2 = $db2->get_entries_since($tin_table_in_db1, "create_date", $last_date_tin_db1 );

 

 
 
if(count($fresh_rows_in_db_1) > 0){

        $db2->insert_fresh_rows("res_partner", $fresh_rows_in_db_1);
}
else{

        $db2->log("No new records found in db 1");
}

if(count($fresh_rows_in_db_2) > 0){

        $db1->insert_fresh_rows("res_partner", $fresh_rows_in_db_2);
}
else{

        $db1->log("No new records found in db 2");
}

?>