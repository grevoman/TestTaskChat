$(document).ready(function () {
    var $form = $('#add-message-form');
    $form.on('beforeSubmit', function () {
        var data = $form.serialize();
        $.ajax({
            url: $form.data('add-message-url'),
            type: 'POST',
            data: data,
            success: function (data) {
                if (data.success) {
                    $form.find('input[type=text]').val('');
                    $.pjax.reload({container: '#message-list-pjax', async: false});
                }
            },
            error: function (jqXHR, errMsg) {
                console.log(errMsg);
            }
        });
        return false;
    });

    $('.mark-incorrect').on('click', function (event) {
        $.ajax({
            url: $form.data('incorrect-message-url'),
            type: 'POST',
            data: {'id': $(this).data('id')},
            success: function (data) {
                if (data.success) {
                    $.pjax.reload({container: '#message-list-pjax', async: false});
                }
            },
            error: function (jqXHR, errMsg) {
                console.log(errMsg);
            }
        });
    });
});