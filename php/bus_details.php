<?php
/**
 * Created by Fateslayer
 */
include_once("functions.php");
if(isset($_POST['bus_num']) && isset($_POST['bus_route']))
{
    $bus_num = process_input($_POST['bus_num']);
    $bus_route = process_input($_POST['bus_route']);
    $query = "SELECT stops FROM routes WHERE route='$bus_route'";
    $result = database($query);
    if($result != false)
    {
        echo("<h2 class='lawngreen_font'>Route Details For Bus No. ".$bus_num." For Route: ".$bus_route."</h2>");
        $table = "
            <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>Bus Stop Number</th>
                    <th>Bus Stop Name</th>
                </tr>
            </thead>
            <tbody>";
        $i = 1;
        $stops = mysqli_fetch_assoc($result);
        foreach(explode(", ", $stops['stops']) as $value)
        {
            $table .= "
                <tr>
                    <td>{$i}</td>
                    <td>{$value}</td>
                </tr>";
            $i++;
        }
        $table .= "</tbody></table>";
        echo($table);
    }
    else
    {
        echo("<h2 class='orange_font'>No Result Found!</h2>");
    }
}
else
{
    echo("<h2 class='orange_font'>No Bus Selected!</h2>");
}
?>