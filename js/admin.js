/**
 * Created by Fateslayer
 */
$(document).ready(function(){
    var select_mode = edit_mode = false;
    var table_name = $(".table").attr("id");
    $("#edit_btn").click(function(){
        $(".dropdown_edit").toggle();
        select_mode = false;
        if(edit_mode)
        {
            edit_mode = false;
            $("#status_message").text("Status: Edit Mode Disabled").css('color','azure');
            $(".edit").attr('contenteditable', 'false');
        }
        else
        {
            edit_mode = true;
            $("#status_message").text("Status: Edit Mode Enabled").css('color','gold');
            $(".edit").attr('contenteditable', 'true');
        }
    });

    var old_message;
    $("td").click(function(){
        if(select_mode)
        {
            $(this).parent().toggleClass('selected');
        }
        old_message = $(this).text();
    }).blur(function(){
        var new_message = $(this).text();
        if(old_message!=new_message)
        {
            $(this).addClass("changed");
            old_message = null;
            new_message = null;
        }
    }).hover(function(){
        $(this).parent().css("background", "orange");
    }, function(){
        $(this).parent().css("background", "transparent");
    });

    $(document).on("change", ".route_select", function(e){
        var x = this.options[e.target.selectedIndex].text;
        $(this).parent().siblings().eq(2).text(x);
        $(this).parent().siblings().eq(2).addClass("changed");
    });

    $("#add_btn").click(function(){
        if($(".table tr").hasClass("new"))
        {
            alert("Please Fill The Empty Table");
            $(".table tbody>tr:last>td").eq(1).focus();
        }
        else
        {
            if(table_name == 'buses')
            {
                $(".table > tbody").append("<tr><td id='id' class='hide'></td><td id='bus_num' class='edit'></td><td id='route'></td><td class='dropdown_edit'></td><td id='a1_a1t' class='edit'></td><td id='a2_a2t' class='edit'></td><td id='d1_d1t' class='edit'></td><td id='d2_d2t' class='edit'></td></tr>");
            }
            else if(table_name == 'routes')
            {
                $(".table > tbody").append("<tr><td id='id' class='hide'></td><td id='route' class='edit'></td><td id='stops' class='edit'></td></tr>");
            }
            $(".table tbody>tr:last>td").eq(1).attr('contenteditable', 'true').focus();
            $(".table tbody>tr:last").addClass("new");
        }
    });

    $("#select_btn").click(function(){
        if(select_mode)
        {
            $("#status_message").text("Status: Select Mode Disabled").css('color','azure');
            select_mode=false;
        }
        else
        {
            $("#status_message").text("Status: Select Mode Enabled").css('color','gold');
            select_mode=true;
        }
    });

    $("#reset_btn").click(function(){
        location.reload();
    });

    $("#remove_btn").click(function(){
        if($("tr").hasClass("selected"))
        {
            var id_list = [];
            $(".selected").each(function(){
                id_list.push($(this).children().eq(0).text());
            });
            $.post("../php/admin.php",
                {
                    mode:"remove",
                    table_name:table_name,
                    id_list:id_list
                },
                function(response,status){
                    if(response)
                    {
                        alert(response);
                        $("tr").removeClass("selected");
                    }
                    else
                    {
                        alert(response);
                    }
                    location.reload();
                });
        }
        select_mode=false;
    });

    $("#submit_btn").click(function(){
        if($("tr").hasClass("new"))
        {
            var id = "";
            $(".new").each(function(){
                id = $(".new").children().eq(1).text();
            });
            $.post("../php/admin.php",
                {
                    mode:"add",
                    table_name:table_name,
                    id: id
                },
                function(response,status){
                    if(response)
                    {
                        alert(response);
                        $("tr").removeClass("new");
                    }
                    else
                    {
                        alert(response);
                    }
                    location.reload();
                });
        }
        if($("td").hasClass("changed")){
            var id_list = [];
            var cn_list = [];
            var value_list = [];
            $(".changed").each(function(){
                id_list.push($(this).parent().children().eq(0).text());
                cn_list.push($(this).attr("id"));
                value_list.push($(this).text());
            });
            $.post("../php/admin.php",
                {
                    mode:"change",
                    table_name:table_name,
                    id_list:id_list,
                    cn_list:cn_list,
                    value_list:value_list
                },
                function(response,status){
                    if(response)
                    {
                        alert(response);
                        $("td").removeClass("changed");
                    }
                    else
                    {
                        alert(response);
                    }
                    location.reload();
                });
        }
    });

    $("#remove_message_btn").click(function(){
        var id = [];
        id.push($(this).siblings().first().text());
        $.post("../php/admin.php",
            {
                mode:"remove",
                table_name:"feedback",
                id_list:id
            },
            function(response,status){
                if(response)
                {
                    alert(response);
                }
                else
                {
                    alert(response);
                }
                location.reload();
            });
    });
});
