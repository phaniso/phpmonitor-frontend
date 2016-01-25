$(document).ready(function () {
    $.ajaxSetup({
        data: csrf_token_name
    });
    
    $("a").filter("#delete").click(function () {
        var id = $(this).attr('name');
        var confirmation = confirm("Are you sure?");
        if (confirmation !== true) {
            return; 
        }
        $.ajax({
            url : "notification/delete",
            type : "POST",
            data : {
                id : id,
                csrf_token_name : csrf_token_name
            },
            cache : false,
            success : function (data) {
                if ( typeof data.error === "undefined") {
                    $("#notification_" + id).hide();
                } else {
                    $('#response').text(data.error);
                    $('#response').show();
                }
            },
        });
    });
});

