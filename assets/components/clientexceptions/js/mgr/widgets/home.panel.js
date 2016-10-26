ClientExceptions.panel.Home = function(config) {
	config = config || {};
	
    Ext.apply(config, {
        id			: 'clientexceptions-panel-home',
        cls			: 'container',
        defaults	: {
        	collapsible	: false,
        	autoHeight	: true,
        	border 		: false
        },
        items		: [{
            html		: '<h2>'+_('clientexceptions')+'</h2>',
            id			: 'clientexceptions-header',
            cls			: 'modx-page-header'
        }, {
        	layout		: 'form',
        	border 		: true,
            defaults	: {
            	autoHeight	: true,
            	border		: false
            },
            items		: [{
            	html			: '<p>' + _('clientexceptions.exceptions_desc') + '</p>',
                bodyCssClass	: 'panel-desc'
            }, {
                xtype			: 'clientexceptions-grid-exceptions',
                cls				: 'main-wrapper',
                preventRender	: true
            }]
        }]
    });

	ClientExceptions.panel.Home.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.panel.Home, MODx.FormPanel);

Ext.reg('clientexceptions-panel-home', ClientExceptions.panel.Home);