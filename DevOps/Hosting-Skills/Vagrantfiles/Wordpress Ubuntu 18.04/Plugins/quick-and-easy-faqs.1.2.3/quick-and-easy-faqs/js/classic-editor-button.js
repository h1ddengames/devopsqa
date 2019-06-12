(function() {
    tinymce.create("tinymce.plugins.faqs_button", {

        /**
         * Add FAQs Button 
         * 'url' argument holds the absolute url of our plugin directory
         **/
        
        init : function(ed, url) {
            
            ed.addButton("faqs", {
                text : "FAQs",
                type  : 'menubutton',
                icon  : false,
                menu: [
                    {
                        text: 'Display FAQs Only',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs]');
                        }
                    },
                    {
                        text: 'Display Grouped FAQs',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs grouped="yes"]');
                        }
                    },
                    {
                        text: 'Display Toggle Styled FAQs',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="toggle"]');
                        }
                    },
                    {
                        text: 'Display Filterable Toggle Styled FAQs',
                        onclick: function() {
                            ed.execCommand('mceInsertContent', 0, '[faqs style="filterable-toggle"]');
                        }
                    } 
                ]
            });

        },
    });

    tinymce.PluginManager.add("faqs_button", tinymce.plugins.faqs_button);

    
})();