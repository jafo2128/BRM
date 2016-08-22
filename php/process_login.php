<?php
/**
* Created by Fateslayer
*/
include_once("functions.php");
$error = "";
if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(process_login($username, $password))
    {
        header("Location:/BRM/html/admin.html");
        exit();
    }
    else
    {
        $error = "<h2 class='orange_font'>Username Or Password Didn't Match!</h2>";
    }
}
?>
<div class='center-block'>
    <form action='<?php echo(htmlspecialchars($_SERVER['PHP_SELF'])); ?>' method='post'>
        <?php
        if(!empty($error))
        {
            echo($error);
        }
        ?>
        <h2 class="lawngreen_font">Please Login:</h2>
        <div class='form-group'>
            <label for='username'>Username:</label>
            <input type='text' class='form-control' id='username' name='username' pattern='[a-z0-9]{4,30}' autofocus required maxlength='30'>
        </div>
        <div class='form-group'>
            <label for='password'>Password:</label>
            <input type='password' class='form-control' id='password' name='password' pattern='[a-z0-9]{4,30}' required maxlength='30'>
        </div>
        <button type='submit' class='btn btn-success center-block' id='login_btn_submit'>Submit</button>
    </form>
</div>
