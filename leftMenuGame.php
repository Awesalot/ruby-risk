<?php
require dirname(__FILE__)."/dbman/includes/functions.php";
$dbc = new DbConn;
$tbl_games = $dbc->tbl_games;
$query = "select name, dir from ".$tbl_games." order by name";
$res = $dbc->conn->query($query);

while($row = $res->fetch_array()){
    $rows[] = $row;
}

echo "<ul>";
echo "<li><a href='backroom/addgame.php'>Add game</a></li><br/>";
echo "<li><h4>Games</h4></li>";

if(!empty($rows)) {
    foreach ($rows as $row) {
        $name = $row['name'];
        $dir  = $row['dir'];
        echo "<li><a href='$dir'>$name</a></li>";
    }
}

echo"</ul>";
