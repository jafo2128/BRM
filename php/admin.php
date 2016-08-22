<?php
/**
 * Created by Fateslayer
 */
include_once("functions.php");
if(isset($_POST['mode']) && isset($_POST['table_name']))
{
    $query = "";
    $mode = $_POST['mode'];
    $table_name = $_POST['table_name'];
    if($mode == "add")
    {
        if(isset($_POST['id']))
        {
            $id = $_POST['id'];
            if($table_name == "buses")
            {
                $query = "INSERT INTO $table_name (bus_num) VALUES ('$id')";
            }
            elseif($table_name == "routes")
            {
                $query = "INSERT INTO $table_name (route) VALUES ('$id')";
            }
        }
    }
    elseif($mode == "remove")
    {
        if(isset($_POST['id_list']))
        {
            $id_list = $_POST['id_list'];
            $ids = array_string($id_list);
            $query = "DELETE FROM $table_name WHERE id IN ($ids)";
        }
    }
    elseif($mode == "change")
    {
        $total = $passed = $failed = 0;
        if(isset($_POST['id_list']) && isset($_POST['cn_list']) && isset($_POST['value_list']))
        {
            $id_list = $_POST['id_list'];
            $cn_list = $_POST['cn_list'];
            $value_list = $_POST['value_list'];
            $unique_ids = array_unique($id_list);
            $total = count($unique_ids);
            foreach($unique_ids as $uid)
            {
                $col_val = "";
                $index_list = get_index_list($uid, $id_list);
                foreach($index_list as $i)
                {
                    if($cn_list[$i]=='a1_a1t' || $cn_list[$i]=='a2_a2t' || $cn_list[$i]=='d1_d1t' || $cn_list[$i]=='d2_d2t')
                    {
                        $t = substr($cn_list[$i],0, 2);
                        $tz = substr($cn_list[$i], 3);
                        $t_data = substr($value_list[$i],0, 8);
                        $tz_data = substr($value_list[$i], 9, 10);
                        if($t_data == "" || $tz_data == "")
                        {
                            $t_data = "NULL";
                            $tz_data = "NULL";
                            $col_val .= $t."=".$t_data.",";
                            $col_val .= $tz."=".$tz_data.",";
                        }
                        else
                        {
                            $col_val .= $t."='".$t_data."',";
                            $col_val .= $tz."='".$tz_data."',";
                        }
                    }
                    else
                    {
                        $col_val .= $cn_list[$i]."='".$value_list[$i]."',";
                    }
                }
                $col_val = substr($col_val, 0, -1);
                $query = "UPDATE $table_name SET $col_val WHERE id=$uid";
                $result = database($query);
                if($result != false)
                {
                    $passed++;
                }
                else
                {
                    $failed++;
                }
            }
            echo("Total: ".$total."\nUpdated: ".$passed."\nFailed: ".$failed);
            exit();
        }
    }
    if(!empty($query))
    {
        $result = database($query);
        if($result != false)
        {
            echo("Success");
        }
        else
        {
            echo("Failed");
        }
    }
    else
    {
        echo("No Query Set");
    }
}
?>