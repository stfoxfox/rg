$(document).ready(function (e) {
    var $form = $('form');

    $form.on('beforeSubmit', function (e) {
        var url = $(this).attr('action'),
            data = new FormData($(this)[0]);

        $.post({
            url: url, data: data,
            processData: false,
            contentType: false,
            success: function (json) {
                if (json.validate) {
                    $form.yiiActiveForm('updateMessages', json.validate);
                }
            }
        });

        return false;
    });

});