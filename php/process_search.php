<?php
/**
 * Created by Fateslayer
 */
include_once("functions.php");
$table = "";
if(isset($_POST["input_num"]))
{
    $input = $_POST["input_num"];
    $input = process_input($input);
    echo("<h2 class='lawngreen_font'>Search Results For Bus No. ".$input."</h2>");
    $result = get_table("buses", "SELECT * FROM buses WHERE bus_num='$input'");
    if($result != false)
    {
        $table .= $result;
        echo($table);
    }
    else
    {
        echo("<h2 class='orange_font'>No Result Found!</h2>");
    }
}
elseif(isset($_POST["input_stop"]))
{
    $input = $_POST["input_stop"];
    $input = process_input($input);
    echo("<h2 class='lawngreen_font'>Search Results For Bus Stop: ".$input."</h2>");
    $stops_result = database("SELECT route FROM routes WHERE stops LIKE '%$input%'");
    if($stops_result != false)
    {
        $list_routes = [];
        while($row = mysqli_fetch_assoc($stops_result))
        {
            array_push($list_routes, $row['route']);
        }
        $list_routes = array_string($list_routes);
        $result = get_table("buses", "SELECT * FROM buses WHERE route IN ($list_routes)");
        if($result != false)
        {
            $table .= $result;
            echo($table);
        }
        else
        {
            echo("<h2 class='orange_font'>No Result Found!</h2>");
        }
    }
    else
    {
        echo("<h2 class='orange_font'>No Stop Found!</h2>");
    }
}
?>