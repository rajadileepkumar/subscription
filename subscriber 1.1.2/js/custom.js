var $ = jQuery.noConflict();

$(function () {
            $('#multiSelect').multiselect({
                includeSelectAllOption: true
            });
            // $('.btn-primary').click(function () {
            //     var selected = $("#multiSelect option:selected");
            //     var message = "";
            //     selected.each(function () {
            //         message += $(this).text() + " " + $(this).val() + "\n";
            //     });
            //     alert(message);
            // });
        });

