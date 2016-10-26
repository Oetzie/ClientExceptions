ClientExceptions.grid.Exceptions = function(config) {
    config = config || {};

	config.tbar = [{
        text	: _('clientexceptions.exception_create'),
        cls		:'primary-button',
        handler	: this.createException,
        scope	: this
    }, {
		text	: _('bulk_actions'),
		menu	: [{
			text	: _('clientexceptions.exceptions_remove_selected'),
			handler	: this.removeSelectedExceptions,
			scope	: this
		}, '-', {
			text	: _('clientexceptions.exceptions_activate_selected'),
			name	: 'activate',
			handler	: this.activateSelectedExceptions,
			scope	: this
		}, {
			text	: _('clientexceptions.exceptions_deactivate_selected'),
			name	: 'deactivate',
			handler	: this.activateSelectedExceptions,
			scope	: this
		}, '-', {
       		text	: _('clientexceptions.exceptions_import'),
	   		handler	: this.importExceptions,
	   		scope	: this
		}, {
       		text	: _('clientexceptions.exceptions_export'),
	   		handler	: this.exportExceptions,
	   		scope	: this
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
		},
		width: 150
    }, {
    	xtype		: 'modx-combo-context',
    	hidden		: 0 == parseInt(ClientExceptions.config.context) ? true : false,
    	name		: 'clientexceptions-filter-context',
        id			: 'clientexceptions-filter-context',
        emptyText	: _('clientexceptions.filter_context'),
        listeners	: {
        	'select'	: {
            	fn			: this.filterContext,
            	scope		: this   
		    }
		},
		width: 250
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
	        'render'		: {
		        fn			: function(cmp) {
			        new Ext.KeyMap(cmp.getEl(), {
				        key		: Ext.EventObject.ENTER,
			        	fn		: this.blur,
				        scope	: cmp
			        });
		        },
		        scope	: this
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
    
    sm = new Ext.grid.CheckboxSelectionModel();
    
    expander = new Ext.grid.RowExpander({
        tpl : new Ext.Template(
            '<p class="desc">{description}</p>'
        )
    });

    columns = new Ext.grid.ColumnModel({
       columns: [sm, expander, {
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
            width		: 200,
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
            dataIndex	: 'context',
            sortable	: true,
            hidden		: true,
            editable	: false
        }]
    });
    
    Ext.applyIf(config, {
    	sm 			: sm,
    	cm			: columns,
        id			: 'clientexceptions-grid-exceptions',
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
        	action		: 'mgr/exceptions/getlist'
        },
        autosave	: true,
        save_action	: 'mgr/exceptions/updatefromgrid',
        fields		: ['id', 'context', 'type', 'ip', 'name', 'description', 'active', 'editedon'],
        paging		: true,
        pageSize	: MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy		: 'id',
        grouping	: 0 == parseInt(ClientExceptions.config.context) ? false : true,
        groupBy		: 'context',
        singleText	: _('clientexceptions.exception'),
        pluralText	: _('clientexceptions.exceptions'),
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
    filterContext: function(tf, nv, ov) {
        this.getStore().baseParams.context = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
	    this.getStore().baseParams.type = '';
    	this.getStore().baseParams.context = '';
	    this.getStore().baseParams.query = '';
	    Ext.getCmp('clientexceptions-filter-type').reset();
	    Ext.getCmp('clientexceptions-filter-context').reset();
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
        	title 	: _('clientexceptions.exception_remove'),
        	text	: _('clientexceptions.exception_remove_confirm'),
        	url		: ClientExceptions.config.connector_url,
        	params	: {
            	action	: 'mgr/exceptions/remove',
            	id		: this.menu.record.id
            },
            listeners: {
            	'success'	: {
            		fn			: this.refresh,
            		scope		: this
            	}
            }
    	});
    },
    removeSelectedExceptions: function(btn, e) {
    	var cs = this.getSelectedAsList();
    	
        if (cs === false) {
        	return false;
        }
        
    	MODx.msg.confirm({
        	title 	: _('clientexceptions.exceptions_remove_selected'),
        	text	: _('clientexceptions.exceptions_remove_selected_confirm'),
        	url		: ClientExceptions.config.connector_url,
        	params	: {
            	action	: 'mgr/exceptions/removeselected',
            	ids		: cs
            },
            listeners: {
            	'success'	: {
            		fn			: function() {
            			this.getSelectionModel().clearSelections(true);
            			this.refresh();
            		},
            		scope		: this
            	}
            }
    	});
    },
    activateSelectedExceptions: function(btn, e) {
    	var cs = this.getSelectedAsList();
    	
        if (cs === false) {
        	return false;
        }
        
    	MODx.msg.confirm({
        	title 	: _('clientexceptions.exceptions_activate_selected'),
        	text	: _('clientexceptions.exceptions_activate_selected_confirm'),
        	url		: ClientExceptions.config.connector_url,
        	params	: {
            	action	: 'mgr/exceptions/activateselected',
            	ids		: cs,
            	type	: btn.name
            },
            listeners: {
            	'success'	: {
            		fn			: function() {
            			this.getSelectionModel().clearSelections(true);
            			this.refresh();
            		},
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
		        }
	         }
        });
        
        this.importExceptionsWindow.show(e.target);
    },
    exportExceptions: function(btn, e) {
		MODx.Ajax.request({
			url		: ClientExceptions.config.connector_url,
			params	: {
            	action	: 'mgr/exceptions/export'
            },
			listeners: {
				'success'	: {
					fn			: function() {
						location.href = ClientExceptions.config.connector_url + '?action=mgr/exceptions/export&download=1&HTTP_MODAUTH=' + MODx.siteId;
					},
					scope		: this
				},
				'failure'	: {
					fn 			: function() {

					},
					scope		: this
				}
			}
		});
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
    	autoHeight	: true,
        title 		: _('clientexceptions.exception_create'),
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
            action		: 'mgr/exceptions/create'
        },
        defauls		: {
	        labelAlign	: 'top',
            border		: false
        },
        fields		: [{
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
	        	columnWidth	: .2,
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
	    	layout		: 'form',
	    	hidden		: 0 == parseInt(ClientExceptions.config.context) ? true : false,
			defaults 	: {
				labelSeparator : ''	
			},
	    	items		: [{
	        	xtype		: 'modx-combo-context',
	        	fieldLabel	: _('clientexceptions.label_context'),
	        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_context_desc'),
	        	name		: 'context',
	        	anchor		: '100%',
	        	allowBlank	: true
	        }, {
	        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
	        	html		: _('clientexceptions.label_context_desc'),
	        	cls			: 'desc-under'
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
		            id			: 'clientexceptions-custom-ip-create',
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
			        	Ext.getCmp('clientexceptions-custom-ip-create').setValue(ClientExceptions.config.remoteip);
		        	}
		        }]
        	}]
        }, {
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
        }, {
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
    });
    
    ClientExceptions.window.CreateException.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.window.CreateException, MODx.Window);

Ext.reg('clientexceptions-window-exception-create', ClientExceptions.window.CreateException);

ClientExceptions.window.UpdateException = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
    	autoHeight	: true,
        title 		: _('clientexceptions.exception_update'),
        url			: ClientExceptions.config.connector_url,
        baseParams	: {
            action		: 'mgr/exceptions/update'
        },
        defauls		: {
	        labelAlign	: 'top',
            border		: false
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
	    	layout		: 'form',
	    	hidden		: 0 == parseInt(ClientExceptions.config.context) ? true : false,
			defaults 	: {
				labelSeparator : ''	
			},
	    	items		: [{
	        	xtype		: 'modx-combo-context',
	        	fieldLabel	: _('clientexceptions.label_context'),
	        	description	: MODx.expandHelp ? '' : _('clientexceptions.label_context_desc'),
	        	name		: 'context',
	        	anchor		: '100%',
	        	allowBlank	: true
	        }, {
	        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
	        	html		: _('clientexceptions.label_context_desc'),
	        	cls			: 'desc-under'
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
		            id			: 'clientexceptions-custom-ip-update',
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
			        	Ext.getCmp('clientexceptions-custom-ip-update').setValue(ClientExceptions.config.remoteip);
		        	}
		        }]
        	}]
        }, {
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
        }, {
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
        defauls		: {
	        labelAlign	: 'top',
            border		: false
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
            fieldLabel	: _('clientexceptions.label_delimiter'),
            description	: MODx.expandHelp ? '' : _('clientexceptions.label_delimiter_desc'),
            name		: 'delimiter',
            anchor		: '100%',
            allowBlank	: false,
            value 		: ';'
        }, {
        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
            html		: _('clientexceptions.label_delimiter_desc'),
            cls			: 'desc-under'
        }, {
        	xtype		: 'checkbox',
        	boxLabel	: _('clientexceptions.label_headers'),
        	anchor		: '100%',
        	name		: 'headers',
        	checked		: true,
        	inputValue	: 1
        }],
        fileUpload	: true,
        saveBtnText	: _('import')
    });
    
    ClientExceptions.window.ImportExceptions.superclass.constructor.call(this, config);
};

Ext.extend(ClientExceptions.window.ImportExceptions, MODx.Window);

Ext.reg('clientexceptions-window-exceptions-import', ClientExceptions.window.ImportExceptions);

ClientExceptions.combo.ExceptionTypes = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        store: new Ext.data.ArrayStore({
            mode	: 'local',
            fields	: ['type','label'],
            data	: [
               	['0', _('clientexceptions.type_deny')],
               	['1', _('clientexceptions.type_grant')]
            ]
        }),
        remoteSort	: ['label', 'asc'],
        hiddenName	: 'type',
        valueField	: 'type',
        displayField: 'label',
        mode		: 'local'
    });
    
    ClientExceptions.combo.ExceptionTypes.superclass.constructor.call(this,config);
};

Ext.extend(ClientExceptions.combo.ExceptionTypes, MODx.combo.ComboBox);

Ext.reg('clientexceptions-combo-type', ClientExceptions.combo.ExceptionTypes);