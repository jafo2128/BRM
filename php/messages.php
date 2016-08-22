<?php
/**
 * Created by Fateslayer
 */
include_once("functions.php");
$result = database("SELECT * FROM feedback ORDER BY date_time DESC");
if(mysqli_num_rows($result) != 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $message = "<div class='modal-content' id='message_body'>";
        $date_time = new DateTime($row['date_time']);
        $date = $date_time->format('d F Y');
        $time = $date_time->format('h:i:s');
        $message .= "<p id='id' class='hide'>".$row['id']."</p><button class='btn btn-danger btn-sm' id='remove_message_btn'>Delete</button><h4><span>Name:</span> ".$row['name']."</h4><h4><span>E-Mail:</span> ".$row['email']."</h4><h4><span>Date:</span> ".$date."</h4><h4><span>Time:</span> ".$time." ".$row['time_zone']."</h4><h4><span>Message:</span> ".$row['message']."</h4></div>";
        echo $message;
    }
}
else
{
    echo "<h2 class='orange_font'>No Messages Found</h2>";
}
?>