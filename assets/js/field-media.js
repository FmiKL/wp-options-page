jQuery(document).ready(function($) {
    // Open the media library only for inputs that look like media fields.
    const inputMatch = /image|avatar|icon|pdf/i;
    let mediaUploader;

    $(document).on('dblclick', 'input', function(e) {
        e.preventDefault();
        
        if (!($(this).attr('placeholder') && $(this).attr('placeholder').match(inputMatch))) {
            return;
        }

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        const input = this;
        mediaUploader = wp.media();

        mediaUploader.on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            const attachmentUrl = attachment.url;
            const matches = $(input).attr('placeholder').match(/\d+px/);

            // If the placeholder contains a target size (e.g. "300px"),
            // use the closest available image size instead of the full source.
            if (matches && attachment.sizes && Object.keys(attachment.sizes).length > 0) {
                let thumbnailUrl = '';
                const sizes = Object.keys(attachment.sizes).sort((a, b) => {
                    const size = parseInt(matches[0]);
                    return Math.abs(attachment.sizes[a].width - size) - Math.abs(attachment.sizes[b].width - size);
                });

                if (attachment.sizes[sizes[0]].width < attachment.width) {
                    thumbnailUrl = attachment.sizes[sizes[0]].url;
                } else {
                    thumbnailUrl = attachmentUrl;
                }

                $(input).val(thumbnailUrl);
            } else {
                $(input).val(attachmentUrl);
            }

            mediaUploader = null;
        });

        mediaUploader.open();
    });
});
