
jQuery(document).ready(function ($) {

    // Instantiates the variable that holds the media library frame.
    var meta_image_frame, meta_image_frame2;

    // Runs when the image button is clicked.
    $('#meta-image-button').click(function (e) {

        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if (meta_image_frame) {
            meta_image_frame.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text: meta_image.button },
            library: { type: 'image' }
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function () {

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('#meta-image').val(media_attachment.url);
        });

        // Opens the media library frame.
        meta_image_frame.open();
    });

       // Runs when the image button is clicked.
       $('#meta-image-button2').click(function (e) {

        // Prevents the default action from occuring.
        e.preventDefault();

        // If the frame already exists, re-open it.
        if (meta_image_frame2) {
            meta_image_frame2.open();
            return;
        }

        // Sets up the media library frame
        meta_image_frame2 = wp.media.frames.meta_image_frame2 = wp.media({
            title: meta_image.title,
            button: { text: meta_image.button },
            library: { type: 'image' }
        });

        // Runs when an image is selected.
        meta_image_frame2.on('select', function () {

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame2.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            $('#meta-image2').val(media_attachment.url);
        });

        // Opens the media library frame.
        meta_image_frame2.open();
    });

    $('#project_img_2').click(function(){
     
        $('#meta-image2').val('');
        $(this).parent('.image-preview').remove();
    });
    $('#project_img_1').click(function(){
        $('#meta-image').val('');
        $(this).parent('.image-preview').remove();
    });



});