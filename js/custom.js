var $ = jQuery.noConflict();
//$('.selectpicker').selectpicker('selectAll');
//$('.selectpicker').selectpicker('deselectAll');
// $(document).ready(function() {
// 	$('#newSubscriber').find('[name="multiselect"]')
//             .multiselect({
//                 enableFiltering: true,
//                 includeSelectAllOption: true,
//                 // Re-validate the multiselect field when it is changed
//                 onChange: function(element, checked) {
//                     $('#newSubscriber').formValidation('revalidateField', 'multiselect');

//                     adjustByScrollHeight();
//                 },
//                 onDropdownShown: function(e) {
//                     adjustByScrollHeight();
//                 },
//                 onDropdownHidden: function(e) {
//                     adjustByHeight();
//                 }
//             })
//             .end();
// });

$(function () {
            $('#multiSelect').multiselect({
                includeSelectAllOption: true
            });
            $('.btn-primary').click(function () {
                var selected = $("#multiSelect option:selected");
                var message = "";
                selected.each(function () {
                    message += $(this).text() + " " + $(this).val() + "\n";
                });
                alert(message);
            });
        });