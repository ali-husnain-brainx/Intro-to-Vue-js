<?php
$db = "test";
$db_pwd = "";
$db_user = "root";
$mysqli = new mysqli(getenv( "127.0.0.1" ), $db_user, $db_pwd, $db);
$limit = '';

$limit = $_GET['limit'];
$userData = getUserList($mysqli, $limit);

echo json_encode($userData);

function getUserList($mysqli, $limit) {
    $data = [];
    $query = $mysqli->query( "Select * from users ".$limit );
    if ( $query ) {
        while($row = mysqli_fetch_assoc($query)){
            array_push($data,$row);
        }
    } else {
        //print error message
        echo $mysqli->error;
    }
    return $data;
}