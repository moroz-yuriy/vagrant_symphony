$(document).ready(function () {
    $('.user_form').on("submit", function (e) {
        e.preventDefault();
        if ($(this).data('id') != undefined) {
            method = "PUT";
            url = "/api/user/" + $(this).data('id');
        } else {
            method = "POST";
            url = "/api/user";
        }

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize()
        }).done(function (result) {
            alert(result)
            location.reload();
        });
    });

    $('.delete_user').on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: "/api/user/" + $('.delete_user').data('id'),
            method: "DELETE",
        }).done(function (result) {
            alert(result)
            location.reload();
        });
    });

    $('.group_form').on("submit", function (e) {
        e.preventDefault();
        if ($(this).data('id') != undefined) {
            method = "PUT";
            url = "/api/group/" + $(this).data('id');
        } else {
            method = "POST";
            url = "/api/group";
        }

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize()
        }).done(function (result) {
            alert(result)
            location.reload();
        });
    });

    $('.delete_group').on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: "/api/group/" + $('.delete_group').data('id'),
            method: "DELETE",
        }).done(function (result) {
            alert(result)
            location.reload();
        });
    });


    $('.edit_user, .edit_group').on("click", function (e) {
        e.preventDefault();
        $(this).parent().parent().hide();
        $(this).parent().parent().next().show();
    });

    $('.cancel_user, .cancel_group').on("click", function (e) {
        e.preventDefault();
        $(this).parent().parent().hide();
        $(this).parent().parent().prev().show();
    });


    $('.report').on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "/api/group/" + this.group.value + "/user",
            method: "GET",
        }).done(function (users) {
            $("#user_report").find('tbody').html('');

            jQuery.each(users, function(index, user){
                $("#user_report").find('tbody')
                    .append($('<tr>')
                        .append($('<td>').append(user.name))
                        .append($('<td>').append(user.email))
                        .append($('<td>').append(user.group.name))
                    );
            });
        });
    });
});