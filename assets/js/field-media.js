jQuery(document).ready(function($) {
    const inputMatch = /image|avatar|icon/i;
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
            const imageUrl = attachment.url;
            const matches = $(input).attr('placeholder').match(/\d+px/);

            if (matches && attachment.sizes && Object.keys(attachment.sizes).length > 0) {
                let thumbnailUrl = '';
                const sizes = Object.keys(attachment.sizes).sort((a, b) => {
                    const size = parseInt(matches[0]);
                    return Math.abs(attachment.sizes[a].width - size) - Math.abs(attachment.sizes[b].width - size);
                });

                if (attachment.sizes[sizes[0]].width < attachment.width) {
                    thumbnailUrl = attachment.sizes[sizes[0]].url;
                } else {
                    thumbnailUrl = imageUrl;
                }

                $(input).val(thumbnailUrl);
            } else {
                $(input).val(imageUrl);
            }

            mediaUploader = null;
        });

        mediaUploader.open();
    });
});
