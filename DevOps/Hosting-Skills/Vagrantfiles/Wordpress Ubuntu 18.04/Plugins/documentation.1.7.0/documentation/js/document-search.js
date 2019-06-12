/**
 * documentation-search.js
 *
 * Copyright (c) 2014 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Karim Rahimpur
 * @package documentation
 * @since 1.1.0
 */

jQuery(document).ready(function(){
	// inhibit submitting the form
	jQuery("div.documentation-search-form form").submit(function(){return false;});
});

function documentationSearch( fieldId, containerId, resultsId, url, query ) {

	var $results = jQuery( "#"+resultsId ),
		$blinker = jQuery( "#"+fieldId );

	if ( query != "" ) {
		$blinker.addClass('blinker');
		jQuery.post(
			url,
			{
				"action" : "document_search",
				"document-search": 1,
				"document-query": query
			},
			function ( data ) {
				var results = '';
				for( var key in data ) {
					results += '<div class="entry">';
					results += '<a href="' + data[key].url + '">' + data[key].title + '</a>';
					results += '</div>';
				}
				$results.show().html( results );
				$blinker.removeClass('blinker');
			},
			"json"
		);
	} else {
		$results.hide();
	}
}
