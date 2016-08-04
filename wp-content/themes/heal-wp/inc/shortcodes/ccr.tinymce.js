(function() {
    tinymce.create('tinymce.plugins.ccrtiny', {
        init : function(ed, url) {
            ed.addCommand('shortcodeGenerator', function() {

                tb_show("Heal Shortcodes", url + '/shortcodes.php?&width=630&height=450');

                
            });
            //Add button
            ed.addButton('ccrscgenerator', {    title : 'Shortcodes', cmd : 'shortcodeGenerator', image : url + '/shortcode-icon.png' });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : 'CCR Heal TinyMCE',
                author : 'Codexcoder',
                authorurl : 'http://www.codexcoder.com',
                infourl : 'http://www.codexcoder.com',
                version : tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });
    tinymce.PluginManager.add('ccr_buttons', tinymce.plugins.ccrtiny);
})();