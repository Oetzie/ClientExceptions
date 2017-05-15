Ext.onReady(function() {
	MODx.load({xtype: 'clientexceptions-page-home'});
});

ClientExceptions.page.Home = function(config) {
	config = config || {};
	
	config.buttons = [];
	
	if (ClientExceptions.config.branding) {
		config.buttons.push({
			text 		: 'ClientExceptions ' + ClientExceptions.config.version,
			cls			: 'x-btn-branding',
			handler		: this.loadBranding
		});
	}
	
	config.buttons.push({
    	xtype		: 'modx-combo-context',
    	hidden		: ClientExceptions.config.context,
        value 		: MODx.request.context || MODx.config.default_context,
		name		: 'clientexceptions-filter-context',
        emptyText	: _('clientexceptions.filter_context'),
        listeners	: {
        	'select'	: {
            	fn			: this.filterContext,
            	scope		: this   
		    }
		},
		baseParams	: {
			action		: 'context/getlist',
			exclude		: 'mgr'
		}
    }, {
		text		: _('help_ex'),
		handler		: MODx.loadHelpPane,
		scope		: this
	});
	
	Ext.applyIf(config, {
		components	: [{
			xtype		: 'clientexceptions-panel-home',
			renderTo	: 'clientexceptions-panel-home-div'
		}]
	});
	
	ClientExceptions.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.page.Home, MODx.Component, {
	loadBranding: function(btn) {
		window.open(ClientExceptions.config.branding_url);
	},
	filterContext: function(tf) {
		var request = MODx.request || {};
		
        Ext.apply(request, {
	    	'context' : tf.getValue()  
	    });
	    
        MODx.loadPage('?' + Ext.urlEncode(request));
	}
});

Ext.reg('clientexceptions-page-home', ClientExceptions.page.Home);