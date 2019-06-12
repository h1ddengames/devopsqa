(function( $ ) {
	'use strict';

    /**
     * FAQ's setup
     * 
     * Remove .nojs from .qe-faq-toggle elements, and collapse all expanded
     * elements
     */
    $(function() {
	var all_toggles = $('.qe-faq-toggle');
	all_toggles.removeClass( 'nojs active' );
	all_toggles.find('i.fa').removeClass( 'fa-minus-circle' ).addClass( 'fa-plus-circle' );
    });

    /**
     * FAQs Toggles
     */
    $(function() {
        $('.qe-toggle-title').click(function () {
            var parent_toggle = $(this).closest('.qe-faq-toggle');
            if ( parent_toggle.hasClass( 'active' ) ) {
                $(this).find('i.fa').removeClass( 'fa-minus-circle' ).addClass( 'fa-plus-circle' );
                parent_toggle.removeClass( 'active' ).find( '.qe-toggle-content' ).slideUp( 'fast' );
            } else {
                $(this).find('i.fa').removeClass( 'fa-plus-circle' ).addClass( 'fa-minus-circle' );
                parent_toggle.addClass( 'active' ).find( '.qe-toggle-content' ).slideDown( 'fast' );
            }
        });
    });

    /**
     * FAQs Filter
     */
    $(function() {
        $('.qe-faqs-filter').click( function ( event ) {
            event.preventDefault();
            $(this).parents('li').addClass('active').siblings().removeClass('active');
            var filterSelector = $(this).attr( 'data-filter' );
            var allFAQs = $( '.qe-faq-toggle' );
            if ( filterSelector == '*' ) {
                allFAQs.show();
            } else {
                allFAQs.not( filterSelector ).hide().end().filter( filterSelector ).show();
            }
        });
    });

})( jQuery );
