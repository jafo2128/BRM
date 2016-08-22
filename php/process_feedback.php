<?php
/**
 * Created by Fateslayer
 */
include_once("functions.php");
$op_message = "";
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']))
{
    $name = process_input($_POST['name']);
    $email = process_input($_POST['email']);
    $message = process_input($_POST['message']);
    date_default_timezone_set("Asia/Calcutta");
    $date_time = date("Y-m-d h:i:s");
    $time_zone = date("a");
    if((!empty($name)) && (!empty($email)) && (!empty($message)))
    {
        $result = database("INSERT INTO feedback (id, name, email, message, date_time, time_zone) VALUES(NULL, '$name', '$email', '$message', '$date_time', '$time_zone')");
        if($result)
        {
            $op_message = "Feedback Sent!";
        }
        else
        {
            $op_message = "Feedback Sending Failed!";
        }
    }
    else
    {
        $op_message = "Invalid Input";
    }
    $op_message = "<h2 class='orange_font'>".$op_message."</h2>";
}
?>
<div class="center-block">
    <form action="<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>" method="post">
        <?php
        if(!empty($op_message))
        {
            echo($op_message);
        }
        ?>
        <h2 class="lawngreen_font">Please Enter Your Feedback:</h2>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" pattern="[a-z A-Z]{4,30}" autofocus required maxlength="30">
        </div>
        <div class="form-group">
            <label for="email">E-Mail:</label>
            <input type="email" class="form-control" id="email" name="email" required maxlength="30">
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="10" required maxlength="3000"></textarea>
        </div>
        <button type="submit" class="btn btn-success center-block" id="login_btn_submit">Submit</button>
    </form>
</div>