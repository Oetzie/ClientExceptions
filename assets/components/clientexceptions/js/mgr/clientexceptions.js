var ClientExceptions = function(config) {
	config = config || {};
	
	ClientExceptions.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions, Ext.Component, {
	page	: {},
	window	: {},
	grid	: {},
	tree	: {},
	panel	: {},
	combo	: {},
	config	: {}
});

Ext.reg('clientexceptions', ClientExceptions);

ClientExceptions = new ClientExceptions();