(function($) {

    // USE STRICT
    "use strict";

    var wpsdColorPicker = ['#wpsd_form_border_color', '#wpsd_form_bg_color', '#wpsd_form_input_border_color', '#wpsd_form_input_bg_color', '#wpsd_form_input_font_color',
        '#wpsd_form_font_color', '#wpsd_button_bg_color', '#wpsd_button_font_color'
    ];

    $.each(wpsdColorPicker, function(index, value) {
        $(value).wpColorPicker();
    });

    $('input#wpsd_media_manager').click(function(e) {

        e.preventDefault();
        var image_frame;
        var prevInputId = $(this).prev().attr('id');
        var previewDivId = $(this).next().attr('id');
        var imgType = $(this).data("image-type");
        if (image_frame) {
            image_frame.open();
        }
        // Define image_frame as wp.media object
        image_frame = wp.media({
            title: 'Select Media',
            multiple: false,
            library: {
                type: 'image',
            }
        });

        image_frame.on('close', function() {
            // On close, get selections and save to the hidden input
            // plus other AJAX stuff to refresh the image preview
            var selection = image_frame.state().get('selection');
            var gallery_ids = new Array();
            var my_index = 0;
            selection.each(function(attachment) {
                gallery_ids[my_index] = attachment['id'];
                my_index++;
            });
            var ids = gallery_ids.join(",");
            $('input#' + prevInputId).val(ids);
            Refresh_Image(ids, previewDivId, imgType);
        });

        image_frame.on('open', function() {
            // On open, get the id from the hidden input
            // and select the appropiate images in the media manager
            var selection = image_frame.state().get('selection');
            var ids = $('input#' + prevInputId).val().split(',');
            ids.forEach(function(id) {
                var attachment = wp.media.attachment(id);
                attachment.fetch();
                selection.add(attachment ? [attachment] : []);
            });

        });

        image_frame.open();
    });

    // Ajax request to refresh the image preview
    function Refresh_Image(the_id, preview_id, img_type) {
        var data = {
            action: 'wpsd_get_image',
            id: the_id,
            prev_id: preview_id,
            img_type: img_type
        };

        $.get(ajaxurl, data, function(response) {

            if (response.success === true) {
                //alert(response.data.image);
                $('#' + preview_id).replaceWith(response.data.image);
            }
        });
    }

    $('.wpsd-closebtn').on('click', function() {
        this.parentElement.style.display = 'none';
    });

    $('#cb-select-all-1').on('click', function() {
        if (this.checked) { // check select status
            $('.bulkSelect').each(function() { //loop through each checkbox
                this.checked = true; //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.bulkSelect').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

    $('#cb-select-all-2').on('click', function() {
        if (this.checked) { // check select status
            $('.bulkSelect').each(function() { //loop through each checkbox
                this.checked = true; //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.bulkSelect').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

    $('.reqDel').on('click', function() {
        var answer = confirm('Are you sure you want to delete this item?');
        if (answer) {
            return true;
        }
        return false;
    });

})(jQuery);