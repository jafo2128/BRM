<?php
/**
 * Created by Fateslayer
*/
include_once("functions.php");
$links = "<a class='btn btn-info navbar-left' href=".get_link("index").">Home</a>";
if(isset($_SESSION['username']) && isset($_SESSION['password']))
{
    $links .= "
        <a class='btn btn-primary navbar-left' href=".get_link("admin").">Admin Zone</a>
        <a class='btn btn-primary navbar-left' href=".get_link("manage_routes").">Manage Routes</a>
        <a class='btn btn-primary navbar-left' href=".get_link("messages").">Messages</a>
        <a class='btn btn-danger navbar-right' href=".get_link("logout").">Logout</a>
        ";
}
else
{
    $links .= "<a class='btn btn-success navbar-right' href=".get_link("login").">Login</a>";
}
$links .= "<a class='btn btn-info navbar-right' href=".get_link("search").">Search</a>";
echo("
        <div class='jumbotron' id='page_header'>
            <h1>Bus Route Manager</h1>
        </div>
        <div class='nav modal-content navigation'>
            ".$links."
        </div>
    ");
?>