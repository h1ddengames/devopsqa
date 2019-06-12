/**
 * FAQs SVG Icon
 */
var faqs_svg_path = wp.element.createElement( 'path',
    { 
        d: "M156.468,349c0,11.046-8.954,20-20,20H88.532c-5.514,0-10,4.486-10,10v21h37.936c11.046,0,20,8.954,20,20s-8.954,20-20,20  H78.532v51c0,11.046-8.954,20-20,20s-20-8.954-20-20V379c0-27.57,22.43-50,50-50h47.936C147.514,329,156.468,337.954,156.468,349z   M472.468,491c0,11.046-8.954,20-20,20s-20-8.954-20-20c0-1.328-0.137-2.624-0.385-3.88c-11.063,14.5-28.511,23.88-48.115,23.88  c-33.359,0-60.5-27.141-60.5-60.5v-61c0-33.359,27.141-60.5,60.5-60.5s60.5,27.141,60.5,60.5v50.784  C461.276,450.927,472.468,469.676,472.468,491z M383.968,471c5.58,0,10.641-2.247,14.341-5.876  c-3.609-3.618-5.841-8.61-5.841-14.124c0-8.199,4.939-15.238,12-18.325V389.5c0-11.304-9.196-20.5-20.5-20.5s-20.5,9.196-20.5,20.5  v61C363.468,461.804,372.664,471,383.968,471z M58.579,289c11.046,0,20-8.954,20-20V80c0-22.056,17.944-40,40-40h245.889  c22.056,0,40,17.944,40,40v189c0,11.046,8.954,20,20,20s20-8.954,20-20V80c0-44.112-35.888-80-80-80H118.579  c-44.112,0-80,35.888-80,80v189C38.579,280.046,47.533,289,58.579,289z M364.468,140c0-11.046-8.954-20-20-20h-206  c-11.046,0-20,8.954-20,20s8.954,20,20,20h206C355.514,160,364.468,151.046,364.468,140z M138.468,200c-11.046,0-20,8.954-20,20  s8.954,20,20,20h125c11.046,0,20-8.954,20-20s-8.954-20-20-20H138.468z M299.468,394v97c0,11.046-8.954,20-20,20s-20-8.954-20-20  v-28h-50v28c0,11.046-8.954,20-20,20s-20-8.954-20-20v-97c0-35.841,29.159-65,65-65S299.468,358.159,299.468,394z M259.468,423v-29  c0-13.785-11.215-25-25-25s-25,11.215-25,25v29H259.468z" 
    } 
);
var faqs_svg = wp.element.createElement('svg', 
	{
		width: 20,
        height: 20,
        viewBox: '0 0 511 511'
    },
    faqs_svg_path
);

/**
 * FAQs Blocks
 */
var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType,
    blockStyle = { };

registerBlockType( 'quick-and-easy-faqs/faqs-only',
    {
        title: 'FAQs',
        icon: faqs_svg,
        category: 'quick-and-easy-faqs',
        edit: function() {
            return el( 'div', { style: blockStyle }, '[faqs]' );
        },
        save: function() {
            return el( 'div', { style: blockStyle }, '[faqs]' );
        },
    }
);

registerBlockType( 'quick-and-easy-faqs/faqs-grouped', 
    {
        title: 'FAQs Group',
        icon: faqs_svg,
        category: 'quick-and-easy-faqs',
        edit: function() {
            return el( 'div', { style: blockStyle }, '[faqs grouped="yes"]' );
        },
        save: function() {
            return el( 'div', { style: blockStyle }, '[faqs grouped="yes"]' );
        },
    }
);

registerBlockType( 'quick-and-easy-faqs/faqs-toggle', 
    {
        title: 'FAQs (Toggle Style)',
        icon: faqs_svg,
        category: 'quick-and-easy-faqs',
        edit: function() {
            return el( 'div', { style: blockStyle }, '[faqs style="toggle"]' );
        },
        save: function() {
            return el( 'div', { style: blockStyle }, '[faqs style="toggle"]' );
        },
    }
);

registerBlockType( 'quick-and-easy-faqs/faqs-filterable-toggle', 
    {
        title: 'FAQs (Filterable Toggle)',
        icon: faqs_svg,
        category: 'quick-and-easy-faqs',
        edit: function() {
            return el( 'div', { style: blockStyle }, '[faqs style="filterable-toggle"]' );
        },
        save: function() {
            return el( 'div', { style: blockStyle }, '[faqs style="filterable-toggle"]' );
        },
    }
);