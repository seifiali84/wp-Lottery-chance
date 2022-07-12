<?php

function SendSQL($sql){
    $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) ;  // connecting to server
    if ($con->connect_error) { // check connection
        die("Connection failed: " . $con->connect_error);
    } 
    if($con->query($sql) === TRUE){
        return "Success.";
    }
    $con->close();
    return "Failed !";

}
function ExecuteSQL($sql){ // read data from table
    $con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) ;  // connecting to server
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $result = $con->query($sql);
    // if ($result->num_rows > 0) {
    //     // output data of each row
    //     while($row = $result->fetch_assoc()) {
    //       echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    //     }
    $con->close();
    return $result;
}

function wp_LC_create_table(){
    global $table_prefix;
    $tablename = $table_prefix."LC_Scores";
    $sql = "CREATE TABLE $tablename AS SELECT ID From wp_users";
    SendSQL($sql);
    $sql = "ALTER TABLE $tablename ADD score int";
    SendSQL($sql);
}
function wp_LC_Add_Score_to_User($userid , $score){
    global $table_prefix;
    $tablename = $table_prefix."LC_Scores";
    $sql = "UPDATE $tablename SET score = $score Where ID = $userid";
    SendSQL($sql);
}
function wp_LC_Add_old_purchases_score(){
    global $table_prefix;
    $tablename = $table_prefix."LC_Scores";
    $sql = "SELECT ID FROM $tablename";
    $result = ExecuteSQL($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $userid = $row['ID']; // create a .txt file and log in it to find bug;
            $orderArg = array('customer_id' => 23,'limit' => -1);
            $orders = wc_get_orders($orderArg);
            $total_purchase = 0;
            if($orders){
                foreach($orders as $order){
                    $total_purchase += $order->calculate_totals();
                }
            }
            wp_LC_Add_Score_to_User($userid , $total_purchase);
        }
    }
}
