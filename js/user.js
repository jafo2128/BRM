/**
 * Created by Fateslayer
 */

$(document).ready(function(){
    $("td").click(function(){
        var bus_number = $(this).parent().children().eq(1).text();
        var bus_route = $(this).parent().children().eq(2).text();
        var form = $("<form action='/BRM/html/bus_details.html' method='post'>" +
            "<input type='hidden' name='bus_num' value='" + bus_number + "'/>" +
            "<input type='hidden' name='bus_route' value='" + bus_route + "' />");
        $("body").append(form);
        $(form).submit();
    }).hover(function(){
        $(this).parent().css("background", "orange");
    }, function(){
        $(this).parent().css("background", "transparent");
    });
});