jQuery( document ).ready(function() {
    'use strict';

    jQuery('body').on('change', ".wtab_chk", function(e) {
        var this_id = this.id;
        this_id = this_id.replace('chk_', '');

        if(jQuery(this).prop('checked')){
            jQuery('#' + this_id).val('1');
        }else{
            jQuery('#' + this_id).val('0');
        }
    });

    jQuery('body').on( 'click', '.wtab_upl', function(e){
        var title = 'Choose or upload';
        var ext = 'jpg';
        var label = 'Confirm';
        var attachto = this.id;
        wtab_importer_upl(title, ext, label, attachto);
    });
});

function wtab_upl(title, ext, label, attachto){
    var _wtab_upl = wp.media({
        title:title,
        library:{type:ext},
        button:{text:label},
        multiple: false
    }).on('select', function() {
        var _uploadedfile = _wtab_upl.state().get('selection').first().toJSON();
        jQuery('#' + attachto).val(_uploadedfile.url);
    }).open();
}
