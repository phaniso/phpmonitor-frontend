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
            url : "admin/server/delete",
            type : "POST",
            data : {
                server_id : id,
                csrf_token_name : csrf_token_name
            },
            cache : false,
            success : function (data) {
                if ( typeof data.error === "undefined") {
                    $("#server_" + id).hide();
                }
            },
        });
        
    });

    $("a").filter("#add").click(function () {
        var name = $("#name").val();
        var url_path = $("#url_path").val();
        var ping_hostname = $("#ping_hostname").val();
            $.ajax({
                url : "admin/server/add",
                type : "POST",
                data : {
                    name : name,
                    url_path : url_path,
                    ping_hostname : ping_hostname,
                    csrf_token_name : csrf_token_name
                },
                cache : false,
                success : function (data) {
                    if (typeof data.error !== "undefined") {
                        $("#response").text(data.error);
                        $("#response").show();
                    } else {
                        location.reload();
                    }
                }
            });
    });
    
    $("a").filter("#updateProfile").click(function () {
        $("#alert").hide();
        var password = $("#password").val();
        var confirm_password = $("#password_confirmation").val();
        $.ajax({
            url : "../admin/editProfile",
            type : "POST",
            data : {
                password : password,
                password_confirmation : confirm_password,
                csrf_token_name : csrf_token_name
            },
            cache : false,
            success : function (data) {
                if ( typeof data.error !== "undefined") {
                    $("#response").text(data.error);
                    $("#response").attr("class", "alert alert-danger")
                    $("#response").show();
                }
                if ( typeof data.success !== "undefined") {
                    $("#response").text(data.success);
                    $("#response").attr("class", "alert alert-success")
                    $("#response").show();
                }
            }
        })
    });
});

