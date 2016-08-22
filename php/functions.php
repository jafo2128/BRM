<?php
/**
 * Created by Fateslayer
 */

// Starting Session
session_start();

// Get Links For Web Pages
function get_link($page_name)
{
    $page_name = strtolower($page_name);
    if($page_name == "index")
    {
        $page_link = "/BRM/".$page_name.".html";
    }
    else
    {
        $page_link = "/BRM/html/".$page_name.".html";
    }
    return $page_link;
}

// Connect To Database
function connect($db_name="brm_database")
{
    $host = "localhost";
    $mysql_user = "root";
    $mysql_pass = "";
    $connect = mysqli_connect($host, $mysql_user, $mysql_pass, $db_name) or die("Couldn't Connect To The Database");
    return $connect;
}

// Get Table From Database
function get_table($table_name, $query="")
{
    if(empty($query))
    {
        $query = "SELECT * FROM $table_name";
    }
    $result = database($query);
    if($result != false)
    {
        if($table_name == "buses")
        {
            $table = "
                <table class='table table-bordered' id='buses'>
                <thead>
                    <tr>
                        <th class='hide'>ID</th>
                        <th>Bus No.</th>
                        <th>Route</th>
                        <th class='dropdown_edit'>Change Route</th>
                        <th>Arrival Time 1</th>
                        <th>Arrival Time 2</th>
                        <th>Departure Time 1</th>
                        <th>Departure Time 2</th>
                    </tr>
                </thead>
                <tbody>";
            $dropdown_list = "<td class='dropdown_edit'><select class='route_select'><option class='default'></option>";
            $result_dropdown = database("SELECT route FROM routes");
            if($result_dropdown != false)
            {
                while($row = mysqli_fetch_assoc($result_dropdown))
                {
                    $dropdown_list .= "<option class='opt'>".$row['route']."</option>";
                }
            }
            $dropdown_list .= "</select></td>";
            while($row = mysqli_fetch_assoc($result))
            {
                $table .= "
                    <tr>
                        <td id='id' class='hide'>{$row['id']}</td>
	                    <td id='bus_num' class='edit'>{$row['bus_num']}</td>
	                    <td id='route'>{$row['route']}</td>
	                    ".$dropdown_list."
	                    <td id='a1_a1t' class='edit'>{$row['a1']} {$row['a1t']}</td>
	                    <td id='a2_a2t' class='edit'>{$row['a2']} {$row['a2t']}</td>
	                    <td id='d1_d1t' class='edit'>{$row['d1']} {$row['d1t']}</td>
	                    <td id='d2_d2t' class='edit'>{$row['d2']} {$row['d2t']}</td>
	                </tr>";
            }
            $table .= "
                </tbody>
                </table>";
            if(mysqli_num_rows($result) != 0)
            {
                return($table);
            }
            else
            {
                return false;
            }
        }
        elseif($table_name=='routes')
        {
            $table = "
                        <table class='table table-bordered' id='routes'>
                        <thead>
                            <tr>
                                <th class='hide'>ID</th>
                                <th>Route</th>
                                <th>Bus Stops</th>
                            </tr>
                        </thead>
                        <tbody>";
            while($row = mysqli_fetch_assoc($result))
            {
                $table .= "<tr><td id='id' class='hide'>{$row['id']}</td><td id='route' class='edit'>{$row['route']}</td><td id='stops' class='edit'>{$row['stops']}</td></tr>";
            }
            $table .= "</tbody></table>";
            if(mysqli_num_rows($result) != 0)
            {
                return($table);
            }
            else
            {
                return false;
            }
        }
        else
        {
            return(false);
        }
    }
    else
    {
        return(false);
    }
}


// To Perform Operations On Database
// NOTE: Function Returns The Result Of Operations So
// Remember To Use mysqli_fetch_assoc() Function If You Performed SELECT Operation
function database($query)
{
    $con = connect();
    $result = mysqli_query($con, $query);
    mysqli_close($con);
    if($result)
    {
        return $result;
    }
    else
    {
        return false;
    }
}

//To Remove SQL Query Characters From Input
function process_input($input)
{
    $input = trim($input);
    $con = connect();
    $input = mysqli_real_escape_string($con, $input);
    mysqli_close($con);
    return $input;
}

// Checking Login For Authentication
function check_login($username="", $password="")
{
    // If No Arguments Given, Use SESSION Variables To Check Login
    if(empty($username) || empty($password))
    {
        if(isset($_SESSION['username']) && isset($_SESSION['password']))
        {
            $username = process_input($_SESSION['username']);
            $password = process_input($_SESSION['password']);
        }
        else
        {
            // Not Logged In And Didn't Sent Username, Password
            return false;
        }
    }
    else
    {
        // Else Use The Given Arguments And Check For Login
        $username = process_input($username);
        $password = process_input($password);
    }
    $result = database("SELECT * FROM login WHERE username='$username'");
    if($result)
    {
        $row = mysqli_fetch_assoc($result);
        if($username == $row['username'] && $password == $row['password'])
        {
            return true;
        }
        else
        {
            // Username Matched But Password Didn't
            return false;
        }
    }
    else
    {
        // Username Or Password Didn't Match
        return false;
    }
}

// Process Login Attempt
function process_login($username, $password)
{
    $username = process_input($username);
    $password = process_input($password);
    // If Login Verified, Set SESSION Variables
    if(check_login($username, $password))
    {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        return true;
    }
    else
    {
        return false;
    }
}

// Process Logout
function process_logout()
{
    // If Logged In Then Destroy Session
    if(check_login())
    {
        session_unset();
        session_destroy();
        return "Logged Out Successfully";
    }
    else
    {
        return "You Are Not Logged In";
    }
}

// Find Index Values Of Search In Array
function get_index_list($value, $array)
{
    $index_list = [];
    for($i=0; $i<count($array); $i++)
    {
        if($value == $array[$i])
        {
            array_push($index_list, $i);
        }
    }
    if(count($index_list) > 0)
    {
        return $index_list;
    }
    else
    {
        return false;
    }
}

// Convert Normal Array To Array Like String
// Example: [1,2,3] To "'1', '2', '3'"
function array_string($array)
{
    if(count($array) < 1)
    {
        return false;
    }
    else
    {
        $new_array = [];
        foreach($array as $item)
        {
            array_push($new_array, "'".$item."'");
        }
        return implode(",", $new_array);
    }
}
?>