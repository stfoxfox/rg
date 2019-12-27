/**
 * Created by anatoliypopov on 03/07/2017.
 */

$(document).ready(function() {


    var dell_item = function () {

        var item_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');
        var dell_url = $(this).data('dell-url');
        var dell_id = $(this).data('dell-id');


        if (dell_id === undefined || dell_id === null) {
            dell_id ="item_";
        }


        if (item_name === undefined || item_name === null) {
            item_name ="";
        }
        if (item_name )
        swal({

                title: "Удалить запись?",
                text: "" + item_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Удалить",
                cancelButtonText: "НЕТ"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: dell_url,
                    data: {
                        'item_id': item_id,
                        _csrf: csrfToken
                    },
                    success: function (json) {


                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {
                            $('#'+dell_id + json.item_id).remove();

                            swal("Deleted!", "\n", "success");
                        }


                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    };








    $('.dell-item').click(dell_item);






});

