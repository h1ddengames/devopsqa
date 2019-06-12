(function( $ ) {
	'use strict';

    /**
     * WordPress color picker for options page
     */
    if( jQuery().wpColorPicker ) {
        $(function() {
            $('.color-picker').wpColorPicker();
        });
    }

})( jQuery );
