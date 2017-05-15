ClientExceptions.grid.Exceptions = function(config) {
    config = config || {};

	config.tbar = [{
        text		: _('clientexceptions.exception_create'),
        cls			: 'primary-button',
        handler		: this.createException,
        scope		: this
    }, {
		text		: _('bulk_actions'),
		menu		: [{
			text		: _('clientexceptions.exceptions_import'),
			handler		: this.importExceptions,
			scope		: this
		}, {
			text		: _('clientexceptions.exceptions_export'),
			handler		: this.exportExceptions,
			scope		: this
		}]
	}, '->', {
    	xtype		: 'clientexceptions-combo-type',
    	name		: 'clientexceptions-filter-type',
        id			: 'clientexceptions-filter-type',
        emptyText	: _('clientexceptions.filter_type'),
        listeners	: {
        	'select'	: {
            	fn			: this.filterType,
            	scope		: this   
		    }
		}
    }, '-', {
        xtype		: 'textfield',
        name 		: 'clientexceptions-filter-search',
        id			: 'clientexceptions-filter-search',
        emptyText	: _('search')+'...',
        listeners	: {
	        'change'	: {
	        	fn			: this.filterSearch,
	        	scope		: this
	        },
	        'render'	: {
		        fn			: function(cmp) {
			        new Ext.KeyMap(cmp.getEl(), {
				        key		: Ext.EventObject.ENTER,
			        	fn		: this.blur,
				        scope	: cmp
			        });
		        },
		        scope		: this
	        }
        }
    }, {
    	xtype		: 'button',
    	cls			: 'x-form-filter-clear',
    	id			: 'clientexceptions-filter-clear',
    	text		: _('filter_clear'),
    	listeners	: {
        	'click'		: {
        		fn			: this.clearFilter,
        		scope		: this
        	}
        }
    }];
    
    expander = new Ext.grid.RowExpander({
        tpl : new Ext.Template(
            '<p class="desc">{description}</p>'
        )
    });

    columns = new Ext.grid.ColumnModel({
       columns: [expander, {
            header		: _('clientexceptions.label_name'),
            dataIndex	: 'name',
            sortable	: true,
            editable	: true,
            width		: 150,
            editor		: {
            	xtype		: 'textfield'
            }
        }, {
            header		: _('clientexceptions.label_ipnumber'),
            dataIndex	: 'ip',
            sortable	: true,
            editable	: true,
            width		: 200,
            fixed		: true,
            editor		: {
            	xtype		: 'textfield'
            }
        }, {
            header		: _('clientexceptions.label_type'),
            dataIndex	: 'type',
            sortable	: true,
            editable	: true,
            width		: 150,
            fixed		: true,
            renderer	: this.renderType,
            editor		: {
            	xtype		: 'clientexceptions-combo-type'
            }
        }, {
            header		: _('clientexceptions.label_active'),
            dataIndex	: 'active',
            sortable	: true,
            editable	: true,
            width		: 100,
            fixed		: true,
			renderer	: this.renderBoolean,
			editor		: {
            	xtype		: 'modx-combo-boolean'
            }
        }, {
            header		: _('last_modified'),
            dataIndex	: 'editedon',
            sortable	: true,
            editable	: false,
            fixed		: true,
			width		: 200,
			renderer	: this.renderDate
        }, {
            header		: _('context'),
            dataIndex	: 'context_name',
            sortable	: true,
            hidden		: true,
            editable	: false
        }]
    });
    
    Ext.applyIf(config, {
    	cm			: columns,
        id			: 'clientexceptions-grid-exceptions',
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
        	action		: 'mgr/exceptions/getlist',
        	context		: MODx.request.context || MODx.config.default_context
        },
        autosave	: true,
        save_action	: 'mgr/exceptions/updatefromgrid',
        fields		: ['id', 'context', 'context_name', 'type', 'ip', 'name', 'description', 'active', 'editedon'],
        paging		: true,
        pageSize	: MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy		: 'id',
        plugins		: expander,
        tools		: [{
            id			: 'plus',
            qtip 		: _('expand_all'),
            handler		: this.expandAll,
            scope		: this
        }, {
            id			: 'minus',
            hidden		: true,
            qtip 		: _('collapse_all'),
            handler		: this.collapseAll,
            scope		: this
        }]
    });
    
    ClientExceptions.grid.Exceptions.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.grid.Exceptions, MODx.grid.Grid, {
	filterType: function(tf, nv, ov) {
        this.getStore().baseParams.type = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
	    this.getStore().baseParams.type = '';
	    this.getStore().baseParams.query = '';
	    
	    Ext.getCmp('clientexceptions-filter-type').reset();
	    Ext.getCmp('clientexceptions-filter-search').reset();
	    
        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
        return [{
	        text	: _('clientexceptions.exception_update'),
	        handler	: this.updateException
	    }, '-', {
		    text	: _('clientexceptions.exception_remove'),
		    handler	: this.removeException
		 }];
    },
    createException: function(btn, e) {
        if (this.createExceptionWindow) {
	        this.createExceptionWindow.destroy();
        }
        
        this.createExceptionWindow = MODx.load({
	        xtype		: 'clientexceptions-window-exception-create',
	        closeAction	:'close',
	        listeners	: {
		        'success'	: {
		        	fn			: this.refresh,
		        	scope		: this
		        }
	         }
        });
        
        this.createExceptionWindow.show(e.target);
    },
    updateException: function(btn, e) {
        if (this.updateExceptionWindow) {
	        this.updateExceptionWindow.destroy();
        }
        
        this.updateExceptionWindow = MODx.load({
	        xtype		: 'clientexceptions-window-exception-update',
	        record		: this.menu.record,
	        closeAction	:'close',
	        listeners	: {
		        'success'	: {
		        	fn			: this.refresh,
		        	scope		: this
		        }
	         }
        });
        
        this.updateExceptionWindow.setValues(this.menu.record);
        this.updateExceptionWindow.show(e.target);
    },
    removeException: function(btn, e) {
    	MODx.msg.confirm({
        	title 		: _('clientexceptions.exception_remove'),
        	text		: _('clientexceptions.exception_remove_confirm'),
        	url			: ClientExceptions.config.connector_url,
        	params		: {
            	action		: 'mgr/exceptions/remove',
            	id			: this.menu.record.id
            },
            listeners	: {
            	'success'	: {
            		fn			: this.refresh,
            		scope		: this
            	}
            }
    	});
    },
    importExceptions: function(btn, e) {
        if (this.importExceptionsWindow) {
	        this.importExceptionsWindow.destroy();
        }
        
        this.importExceptionsWindow = MODx.load({
	        xtype		: 'clientexceptions-window-exceptions-import',
	        closeAction	:'close',
	        listeners	: {
		        'success'	: {
            		fn			: function() {
            			this.getSelectionModel().clearSelections(true);
            			this.refresh();
            		},
		        	scope		: this
		        },
		        'failure'	: {
			        fn  		: function(response) {
				    	MODx.msg.alert(_('failure'), response.message);
					},
					scope		: this
				}
	         }
        });
        
        this.importExceptionsWindow.show(e.target);
    },
    exportExceptions: function(btn, e) {
	    if (this.exportExceptionsWindow) {
	        this.exportExceptionsWindow.destroy();
        }
        
        this.exportExceptionsWindow = MODx.load({
	        xtype		: 'clientexceptions-window-exceptions-export',
	        closeAction	:'close',
	        listeners	: {
		        'success'	: {
            		fn			: function() {
            			location.href = ClientExceptions.config.connector_url + '?action=' + this.exportExceptionsWindow.baseParams.action + '&download=1&HTTP_MODAUTH=' + MODx.siteId;
            		},
		        	scope		: this
		        }
	         }
        });
        
        this.exportExceptionsWindow.show(e.target);
    },
    renderType: function(d, c) {
    	c.css = 1 == parseInt(d) || d ? 'green' : 'red';
    	
    	return 1 == parseInt(d) || d ? _('clientexceptions.type_grant') : _('clientexceptions.type_deny');
    },
    renderBoolean: function(d, c) {
    	c.css = 1 == parseInt(d) || d ? 'green' : 'red';
    	
    	return 1 == parseInt(d) || d ? _('yes') : _('no');
    },
	renderDate: function(a) {
        if (Ext.isEmpty(a)) {
            return '—';
        }

        return a;
    }
});

Ext.reg('clientexceptions-grid-exceptions', ClientExceptions.grid.Exceptions);

ClientExceptions.window.CreateException = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
	    width		: 500,
    	autoHeight	: true,
        title 		: _('clientexceptions.exception_create'),
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
            action		: 'mgr/exceptions/create'
        },
        fields		: [{
        	layout		: 'column',
        	border		: false,
            defaults	: {
                layout		: 'form',
                labelSeparator : ''
            },
        	items		: [{
	        	columnWidth	: .9,
	        	items		: [{
		        	xtype		: 'textfield',
		        	fieldLabel	: _('clientexceptions.label_name'),
		        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_name_desc'),
		        	name		: 'name',
		        	anchor		: '100%',
		        	allowBlank	: false,
		        	maxLength	: 75
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_name_desc'),
		            cls			: 'desc-under'
		        }]
        	}, {
	        	columnWidth	: .1,
	        	style		: 'margin-right: 0;',
	        	items		: [{
			        xtype		: 'checkbox',
		            fieldLabel	: _('clientexceptions.label_active'),
		            description	: MODx.expandHelp ? '' : _('clientexceptions.label_active_desc'),
		            name		: 'active',
		            inputValue	: 1,
		            checked		: true
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_active_desc'),
		            cls			: 'desc-under'
		        }]
        	}]
        }, {
        	layout		: 'column',
        	border		: false,
            defaults	: {
                layout		: 'form',
                labelSeparator : ''
            },
        	items		: [{
	        	columnWidth	: .5,
	        	items		: [{
		        	xtype		: 'clientexceptions-combo-type',
		        	fieldLabel	: _('clientexceptions.label_type'),
		        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_type_desc'),
		        	name		: 'type',
		        	anchor		: '100%',
		        	allowBlank	: false
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		        	html		: _('clientexceptions.label_type_desc'),
		        	cls			: 'desc-under'
		        }]
        	}, {
	        	columnWidth	: .5,
	        	style		: 'margin-right: 0;',
	        	items		: [{
			        xtype		: 'textfield',
		            fieldLabel	: _('clientexceptions.label_description'),
		            description	: MODx.expandHelp ? '' : _('clientexceptions.label_description_desc'),
		            name		: 'description',
		            anchor		: '100%',
		            allowBlank	: true
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_description_desc'),
		            cls			: 'desc-under'
		        }]
        	}]
        }, {
        	layout		: 'column',
        	border		: false,
            defaults	: {
                layout		: 'form',
                labelSeparator : ''
            },
        	items		: [{
	        	columnWidth	: .8,
	        	items		: [{
			        xtype		: 'textfield',
		            fieldLabel	: _('clientexceptions.label_ipnumber'),
		            description	: MODx.expandHelp ? '' : _('clientexceptions.label_ipnumber_desc'),
		            name		: 'ip',
		            anchor		: '100%',
		            allowBlank	: false
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_ipnumber_desc'),
		            cls			: 'desc-under'
		        }]
        	}, {
	        	columnWidth	: .2,
	        	style		: 'margin-right: 0;',
	        	items		: [{
		        	xtype		: 'button',
		        	fieldLabel	: '&nbsp;',
		        	text		: _('clientexceptions.label_own_ipnumber'),
		        	anchor		: '100%',
		        	handler		: function() {
						this.fp.getForm().findField('ip').setValue(ClientExceptions.config.remoteip);
		        	},
		        	scope 		: this
		        }]
        	}]
        }, {
	    	layout		: 'form',
	    	labelSeparator : '',
	    	hidden		: ClientExceptions.config.context,
	    	items		: [{
	        	xtype		: 'modx-combo-context',
	        	fieldLabel	: _('clientexceptions.label_context'),
	        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_context_desc'),
	        	name		: 'context',
	        	anchor		: '100%',
				baseParams	: {
					action		: 'context/getlist',
					exclude		: 'mgr'
				}
	        }, {
	        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
	        	html		: _('clientexceptions.label_context_desc'),
	        	cls			: 'desc-under'
	        }]
	    }]
    });
    
    ClientExceptions.window.CreateException.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.window.CreateException, MODx.Window);

Ext.reg('clientexceptions-window-exception-create', ClientExceptions.window.CreateException);

ClientExceptions.window.UpdateException = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
	    width		: 500,
    	autoHeight	: true,
        title 		: _('clientexceptions.exception_update'),
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
            action		: 'mgr/exceptions/update'
        },
        fields		: [{
            xtype		: 'hidden',
            name		: 'id'
        }, {
        	layout		: 'column',
        	border		: false,
            defaults	: {
                layout		: 'form',
                labelSeparator : ''
            },
        	items		: [{
	        	columnWidth	: .9,
	        	items		: [{
		        	xtype		: 'textfield',
		        	fieldLabel	: _('clientexceptions.label_name'),
		        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_name_desc'),
		        	name		: 'name',
		        	anchor		: '100%',
		        	allowBlank	: false,
		        	maxLength	: 75
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_name_desc'),
		            cls			: 'desc-under'
		        }]
        	}, {
	        	columnWidth	: .1,
	        	style		: 'margin-right: 0;',
	        	items		: [{
			        xtype		: 'checkbox',
		            fieldLabel	: _('clientexceptions.label_active'),
		            description	: MODx.expandHelp ? '' : _('clientexceptions.label_active_desc'),
		            name		: 'active',
		            inputValue	: 1,
		            checked		: true
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_active_desc'),
		            cls			: 'desc-under'
		        }]
        	}]
        }, {
        	layout		: 'column',
        	border		: false,
            defaults	: {
                layout		: 'form',
                labelSeparator : ''
            },
        	items		: [{
	        	columnWidth	: .5,
	        	items		: [{
		        	xtype		: 'clientexceptions-combo-type',
		        	fieldLabel	: _('clientexceptions.label_type'),
		        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_type_desc'),
		        	name		: 'type',
		        	anchor		: '100%',
		        	allowBlank	: false
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		        	html		: _('clientexceptions.label_type_desc'),
		        	cls			: 'desc-under'
		        }]
        	}, {
	        	columnWidth	: .5,
	        	style		: 'margin-right: 0;',
	        	items		: [{
			        xtype		: 'textfield',
		            fieldLabel	: _('clientexceptions.label_description'),
		            description	: MODx.expandHelp ? '' : _('clientexceptions.label_description_desc'),
		            name		: 'description',
		            anchor		: '100%',
		            allowBlank	: true
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_description_desc'),
		            cls			: 'desc-under'
		        }]
        	}]
        }, {
        	layout		: 'column',
        	border		: false,
            defaults	: {
                layout		: 'form',
                labelSeparator : ''
            },
        	items		: [{
	        	columnWidth	: .8,
	        	items		: [{
			        xtype		: 'textfield',
		            fieldLabel	: _('clientexceptions.label_ipnumber'),
		            description	: MODx.expandHelp ? '' : _('clientexceptions.label_ipnumber_desc'),
		            name		: 'ip',
		            anchor		: '100%',
		            allowBlank	: false
		        }, {
		        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
		            html		: _('clientexceptions.label_ipnumber_desc'),
		            cls			: 'desc-under'
		        }]
        	}, {
	        	columnWidth	: .2,
	        	style		: 'margin-right: 0;',
	        	items		: [{
		        	xtype		: 'button',
		        	fieldLabel	: '&nbsp;',
		        	text		: _('clientexceptions.label_own_ipnumber'),
		        	anchor		: '100%',
		        	handler		: function() {
						this.fp.getForm().findField('ip').setValue(ClientExceptions.config.remoteip);
		        	},
		        	scope 		: this
		        }]
        	}]
        }, {
	    	layout		: 'form',
	    	labelSeparator : '',
	    	hidden		: ClientExceptions.config.context,
	    	items		: [{
	        	xtype		: 'modx-combo-context',
	        	fieldLabel	: _('clientexceptions.label_context'),
	        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_context_desc'),
	        	name		: 'context',
	        	anchor		: '100%',
				baseParams	: {
					action		: 'context/getlist',
					exclude		: 'mgr'
				}
	        }, {
	        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
	        	html		: _('clientexceptions.label_context_desc'),
	        	cls			: 'desc-under'
			}]
	    }]
    });
    
    ClientExceptions.window.UpdateException.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.window.UpdateException, MODx.Window);

Ext.reg('clientexceptions-window-exception-update', ClientExceptions.window.UpdateException);

ClientExceptions.window.ImportExceptions = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
    	autoHeight	: true,
        title 		: _('clientexceptions.exceptions_import'),
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
            action		: 'mgr/exceptions/import'
        },
        fields		: [{
	        xtype		: 'fileuploadfield',
            fieldLabel	: _('clientexceptions.label_import_file'),
            description	: MODx.expandHelp ? '' : _('clientexceptions.label_import_file_desc'),
            buttonText	: _('upload.buttons.choose'),
            name		: 'file',
            anchor		: '100%'
        }, {
        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
            html		: _('clientexceptions.label_import_file_desc'),
            cls			: 'desc-under'
        }, {
	        xtype		: 'textfield',
            fieldLabel	: _('clientexceptions.label_import_delimiter'),
            description	: MODx.expandHelp ? '' : _('clientexceptions.label_import_delimiter_desc'),
            name		: 'delimiter',
            anchor		: '100%',
            allowBlank	: false,
            value 		: ';'
        }, {
        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
            html		: _('clientexceptions.label_import_delimiter_desc'),
            cls			: 'desc-under'
        }, {
			xtype		: 'checkboxgroup',
			hideLabel 	: true,
			columns 	: 1,
			items 		: [{
				xtype		: 'checkbox',
				boxLabel	: _('clientexceptions.label_import_headers'),
				anchor		: '100%',
				name		: 'headers',
				checked		: true,
				inputValue	: 1
			}, {
				xtype		: 'checkbox',
				boxLabel	: _('clientexceptions.label_import_reset'),
				anchor		: '100%',
				name		: 'reset',
				checked		: false,
				inputValue	: 1
			}]
	    }],
        fileUpload	: true,
        saveBtnText	: _('import')
    });
    
    ClientExceptions.window.ImportExceptions.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.window.ImportExceptions, MODx.Window);

Ext.reg('clientexceptions-window-exceptions-import', ClientExceptions.window.ImportExceptions);

ClientExceptions.window.ExportExceptions = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
    	autoHeight	: true,
        title 		: _('clientexceptions.exceptions_export'),
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
            action		: 'mgr/exceptions/export'
        },
        fields		: [{
	        xtype		: 'textfield',
            fieldLabel	: _('clientexceptions.label_import_delimiter'),
            description	: MODx.expandHelp ? '' : _('clientexceptions.label_import_delimiter_desc'),
            name		: 'delimiter',
            anchor		: '100%',
            allowBlank	: false,
            value 		: ';'
        }, {
        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
            html		: _('clientexceptions.label_import_delimiter_desc'),
            cls			: 'desc-under'
        }, {
			xtype		: 'checkboxgroup',
			hideLabel 	: true,
			columns 	: 1,
			items 		: [{
				xtype		: 'checkbox',
				boxLabel	: _('clientexceptions.label_import_headers'),
				anchor		: '100%',
				name		: 'headers',
				checked		: true,
				inputValue	: 1
			}]
	    }],
        fileUpload	: true,
        saveBtnText	: _('export')
    });
    
    ClientExceptions.window.ExportExceptions.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.window.ExportExceptions, MODx.Window);

Ext.reg('clientexceptions-window-exceptions-export', ClientExceptions.window.ExportExceptions);

ClientExceptions.combo.ExceptionTypes = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        store: new Ext.data.ArrayStore({
            mode	: 'local',
            fields	: ['type', 'label', 'cls'],
            data	: [
            	[0, _('clientexceptions.type_deny'), 'red'],
				[1, _('clientexceptions.type_grant'), 'green']
            ]
        }),
        remoteSort	: ['label', 'asc'],
        hiddenName	: 'type',
        valueField	: 'type',
        displayField: 'label',
        mode		: 'local',
        //tpl			: new Ext.XTemplate('<tpl for=".">' +
        //	'<div class="x-combo-list-item {cls}">{label}</div>' + 
        //'</tpl>')
    });
    
    ClientExceptions.combo.ExceptionTypes.superclass.constructor.call(this,config);
};

Ext.extend(ClientExceptions.combo.ExceptionTypes, MODx.combo.ComboBox);

Ext.reg('clientexceptions-combo-type', ClientExceptions.combo.ExceptionTypes);