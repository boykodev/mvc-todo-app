$(function () {
   $('.js-preview-btn').click(function (e) {
       e.preventDefault();

       var serialized = $('.js-form').serialize();

       $.post('/ajax/preview', serialized, function (data) {
           $('.js-preview').html(data);
       });
   });

    $('#login-submit').click(function (e) {
        e.preventDefault();

        var serialized = $('.js-login').serialize();

        $.post('/ajax/login', serialized, function (data) {
            if (data.status === data.statuses.ok) {
                location.reload();
            }
        }, 'json');
    });

    $('.js-logout').click(function (e) {
        e.preventDefault();

        $.get('/ajax/logout', function (data) {
            location.reload();
        });
    });


    // ajax file upload
    $('.js-image-upload').change(function (e) {
        $(this).closest('form').one('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "/ajax/upload",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                dataType: 'json',
                cache: false,
                processData:false,
                success: function(data) {
                    if (data.status == data.statuses.ok) {
                        $('.js-image-hidden').val(data.image);
                    }
                },
                error: function(){}
            });
        }).submit();
    });
});