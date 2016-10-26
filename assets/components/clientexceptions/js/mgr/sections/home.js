Ext.onReady(function() {
	MODx.load({xtype: 'clientexceptions-page-home'});
});

ClientExceptions.page.Home = function(config) {
	config = config || {};
	
	config.buttons = [{
		text		: _('help_ex'),
		handler		: MODx.loadHelpPane,
		scope		: this
	}];
	
	Ext.applyIf(config, {
		components	: [{
			xtype		: 'clientexceptions-panel-home',
			renderTo	: 'clientexceptions-panel-home-div'
		}]
	});
	
	ClientExceptions.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.page.Home, MODx.Component);

Ext.reg('clientexceptions-page-home', ClientExceptions.page.Home);