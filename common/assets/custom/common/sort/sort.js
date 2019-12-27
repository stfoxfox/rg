/**
 * Created by anatoliypopov on 05/07/2017.
 */

$(document).ready(function() {
    $(".sortable").sortable({
        forcePlaceholderSize: true,
        opacity: 0.8,
        update: function (event, ui) {
            var data = $(this).sortable('toArray', {attribute: "sort-id"});


            var url = $(this).data('url');
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    sort_data: data,
                    _csrf: csrfToken
                },
                success: function (json) {


                    if (json.error) {
                        swal("Error", "%(", "error");
                    }


                },
                dataType: 'json'
            });
        }
    });
});
