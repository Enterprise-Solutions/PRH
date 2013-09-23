function createGrid (aux_title, aux_height, aux_id, columns, aux_empty, aux_store, aux_params)
{	 
		var grilla = Ext.create('Ext.grid.Panel', {
            title: aux_title,
            id: aux_id,
            width: 'fit',
            padding: 10,
            height: aux_height,
            region: 'center',
            viewConfig:{
        	    loadingText: 'Cargando datos...'
            }, 
            layout: 'fit',
            emptyText: aux_empty,       
            store: aux_store,
            loadMask: true,
            columns:[],
            listener:{
           	 'sortchange': function( ct, column, direction, eOpts ){
	           		Ext.getCmp(aux_store).load({
						 params: aux_params,
					});
              	 }
            }
		 });
		
		var i = 0;	
		for (i=0; i<columns.length ; i++)
        {
			if (columns[i].tipo == '1'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,	
				});
			}
			else if (columns[i].tipo == '2'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,
			           renderer: columns[i].render,
				});
			}
			grilla.headerCt.insert(i, aux_column);
        }
		
		return grilla;	
}

function createGridPag (aux_title, aux_height, aux_id, columns, aux_empty, aux_store, aux_page, aux_params, aux_filtros)
{	 
		var grilla = Ext.create('Ext.grid.Panel', {
            title: aux_title,
            id: aux_id,
            width: 'fit',
            padding: 10,
            height: aux_height,
            region: 'center',
            viewConfig:{
        	    loadingText: 'Cargando datos...'
            },
	        dockedItems: [{
                    xtype: 'pagingtoolbar',
                    store: aux_store,  
                    dock: 'bottom',
                    displayInfo: true,
                    listeners: {
                        'afterrender': function (component)
                        {
                            component.down('#refresh').hide()
                        },single: true
                    },
                    displayMsg: 'Registro {0} al {1} de {2}',
                    beforePageText: 'P&aacute;gina',
                    afterPageText : 'de {0}',
                    moveNext : function(){ 
	                   		aux_page = aux_page + itemsPorPagina;
	                   	 	this.store.currentPage++;
	                   	 	aux_params["p[page]"] = aux_page;
	                   	 	var basicForm = Ext.getCmp('filtros').up('form').getForm();						
				           	var valoresForm = basicForm.getFieldValues();
		                   	var j=0;
					           for (j=0; j<aux_filtros.length; j++){
						           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
					        }
	                   	 	this.store.load({
		        				    params: aux_params,
	       					});
                	 },
                 	 movePrevious : function(){ 
                 		 	aux_page = aux_page - itemsPorPagina;
							this.store.currentPage--;
							aux_params["p[page]"] = aux_page;
							var basicForm = Ext.getCmp('filtros').up('form').getForm();						
				           	var valoresForm = basicForm.getFieldValues();
		                   	var j=0;
					           for (j=0; j<aux_filtros.length; j++){
						           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
					        }
							this.store.load({
	        					 params: aux_params,
	    					});
            		 },
             		moveFirst : function(){ 
             				aux_page = 0;
							this.store.currentPage = 1;
							aux_params["p[page]"] = aux_page;
							var basicForm = Ext.getCmp('filtros').up('form').getForm();						
				           	var valoresForm = basicForm.getFieldValues();
		                   	var j=0;
					           for (j=0; j<aux_filtros.length; j++){
						           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
					        }
							this.store.load({
	        					 params: aux_params,
	    					});
            	 	},
            	 	moveLast : function(){ 
                	 	
            	 		if (this.getStore().getTotalCount() % itemsPorPagina == "0"){
            	 			aux_page = (parseInt(this.getStore().getTotalCount() / itemsPorPagina)-1)*itemsPorPagina;
	                	 	this.store.currentPage = (parseInt(this.getStore().getTotalCount() / itemsPorPagina));
            	 		}
						else
						{
							aux_page = parseInt(this.getStore().getTotalCount() / itemsPorPagina)*itemsPorPagina;
							this.store.currentPage = (parseInt(this.getStore().getTotalCount() / itemsPorPagina)+1);
						}
            	 		aux_params["p[page]"] = aux_page;
            	 		var basicForm = Ext.getCmp('filtros').up('form').getForm();						
			           	var valoresForm = basicForm.getFieldValues();
	                   	var j=0;
				           for (j=0; j<aux_filtros.length; j++){
					           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
				        }
            	 		this.store.load({
            	 			params: aux_params,
            	 		});
   					          					
            	 	}
	        }], 
            layout: 'fit',
            emptyText: aux_empty,       
            store: aux_store,
            loadMask: true,
            columns:[],
            listener:{
           	 'sortchange': function( ct, column, direction, eOpts ){
	           		Ext.getCmp(aux_store).load({
						 params: aux_params,
					});
              	 }
            }
		 });
		
		var i = 0;	
		for (i=0; i<columns.length ; i++)
        {
			if (columns[i].tipo == '1'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,	
				});
			}
			else if (columns[i].tipo == '2'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,
			           renderer: columns[i].render,
				});
			}
			grilla.headerCt.insert(i, aux_column);
        }
		
		return grilla;	
}

function createGridPagSinFil (aux_title, aux_height, aux_id, columns, aux_empty, aux_store, aux_page, aux_params)
{	 
		var grilla = Ext.create('Ext.grid.Panel', {
            title: aux_title,
            id: aux_id,
            width: 'fit',
            padding: 10,
            height: aux_height,
            region: 'center',
            viewConfig:{
        	    loadingText: 'Cargando datos...'
            },
	        dockedItems: [{
                    xtype: 'pagingtoolbar',
                    store: aux_store,  
                    dock: 'bottom',
                    displayInfo: true,
                    listeners: {
                        'afterrender': function (component)
                        {
                            component.down('#refresh').hide()
                        },single: true
                    },
                    displayMsg: 'Registro {0} al {1} de {2}',
                    beforePageText: 'P&aacute;gina',
                    afterPageText : 'de {0}',
                    moveNext : function(){ 
                    		aux_page = aux_page + itemsPorPagina;
	                   	 	this.store.currentPage++;
	                   	 	aux_params["p[page]"] = aux_page;
	                   	 	this.store.load({
		        				    params: aux_params,
	       					});
                	 },
                 	 movePrevious : function(){ 
                 		 	aux_page = aux_page - itemsPorPagina;
							this.store.currentPage--;
							aux_params["p[page]"] = aux_page;
							this.store.load({
	        					 params: aux_params,
	    					});
            		 },
             		moveFirst : function(){ 
             				aux_page = 0;
							this.store.currentPage = 1;
							aux_params["p[page]"] = aux_page;
							this.store.load({
	        					 params: aux_params,
	    					});
            	 	},
            	 	moveLast : function(){ 
                	 	
            	 		if (this.getStore().getTotalCount() % itemsPorPagina == "0"){
            	 			aux_page = (parseInt(this.getStore().getTotalCount() / itemsPorPagina)-1)*itemsPorPagina;
	                	 	this.store.currentPage = (parseInt(this.getStore().getTotalCount() / itemsPorPagina));
            	 		}
						else
						{
							aux_page = parseInt(this.getStore().getTotalCount() / itemsPorPagina)*itemsPorPagina;
							this.store.currentPage = (parseInt(this.getStore().getTotalCount() / itemsPorPagina)+1);
						}
            	 		aux_params["p[page]"] = aux_page;
            	 		this.store.load({
            	 			params: aux_params,
            	 		});
   					          					
            	 	}
	        }], 
            layout: 'fit',
            emptyText: aux_empty,       
            store: aux_store,
            loadMask: true,
            columns:[],
            listener:{
           	 'sortchange': function( ct, column, direction, eOpts ){
	           		Ext.getCmp(aux_store).load({
						 params: aux_params,
					});
              	 }
            }
		 });
		
		var i = 0;	
		for (i=0; i<columns.length ; i++)
        {
			if (columns[i].tipo == '1'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,	
				});
			}
			else if (columns[i].tipo == '2'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,
			           renderer: columns[i].render,
				});
			}
			grilla.headerCt.insert(i, aux_column);
        }
		
		return grilla;	
}

function createGridGroupPag (aux_title, aux_height, aux_id, columns, aux_empty, aux_store, aux_page, aux_params, aux_filtros, aux_group_header, aux_group_text)
{	 
		var grilla = Ext.create('Ext.grid.Panel', {
            title: aux_title,
            id: aux_id,
            width: 'fit',
            padding: 10,
            height: aux_height,
            features: [{
            	id: 'group',
                groupHeaderTpl: aux_group_header,
                ftype: 'groupingsummary'
            }],
            region: 'center',
            viewConfig:{
        	    loadingText: 'Cargando datos...'
            },
	        dockedItems: [{
	               dock: 'top',
	               xtype: 'toolbar',
	               items: [{
			                   text: aux_group_text,
			                   xtype: 'button',
			                   scale: 'small',
			                   pressed: true,
			                   enableToggle: true,
			                   toggleHandler: function(btn, pressed){
			                       var view = Ext.getCmp(aux_id).getView();
			                       view.getFeature('group').toggleSummaryRow(pressed);
			                       view.refresh();
			                   } 
	                     }]
	               },{
                    xtype: 'pagingtoolbar',
                    store: aux_store,  
                    dock: 'bottom',
                    displayInfo: true,
                    listeners: {
                        'afterrender': function (component)
                        {
                            component.down('#refresh').hide()
                        },single: true
                    },
                    displayMsg: 'Registro {0} al {1} de {2}',
                    beforePageText: 'P&aacute;gina',
                    afterPageText : 'de {0}',
                    moveNext : function(){ 
                    		aux_page = aux_page + itemsPorPagina;
	                   	 	this.store.currentPage++;
	                   	 	aux_params["p[page]"] = aux_page;
	                   	 	var basicForm = Ext.getCmp('filtros').up('form').getForm();						
				           	var valoresForm = basicForm.getFieldValues();
		                   	var j=0;
					           for (j=0; j<aux_filtros.length; j++){
						           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
					        }
	                   	 	this.store.load({
		        				    params: aux_params,
	       					});
                	 },
                 	 movePrevious : function(){ 
                 		 	aux_page = aux_page - itemsPorPagina;
							this.store.currentPage--;
							aux_params["p[page]"] = aux_page;
							var basicForm = Ext.getCmp('filtros').up('form').getForm();						
				           	var valoresForm = basicForm.getFieldValues();
		                   	var j=0;
					           for (j=0; j<aux_filtros.length; j++){
						           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
					        }
							this.store.load({
	        					 params: aux_params,
	    					});
            		 },
             		moveFirst : function(){ 
             				aux_page = 0;
							this.store.currentPage = 1;
							aux_params["p[page]"] = aux_page;
							var basicForm = Ext.getCmp('filtros').up('form').getForm();						
				           	var valoresForm = basicForm.getFieldValues();
		                   	var j=0;
					           for (j=0; j<aux_filtros.length; j++){
						           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
					        }
							this.store.load({
	        					 params: aux_params,
	    					});
            	 	},
            	 	moveLast : function(){ 
                	 	
            	 		if (this.getStore().getTotalCount() % itemsPorPagina == "0"){
            	 			aux_page = (parseInt(this.getStore().getTotalCount() / itemsPorPagina)-1)*itemsPorPagina;
	                	 	this.store.currentPage = (parseInt(this.getStore().getTotalCount() / itemsPorPagina));
            	 		}
						else
						{
							aux_page = parseInt(this.getStore().getTotalCount() / itemsPorPagina)*itemsPorPagina;
							this.store.currentPage = (parseInt(this.getStore().getTotalCount() / itemsPorPagina)+1);
						}
            	 		aux_params["p[page]"] = aux_page;
            	 		var basicForm = Ext.getCmp('filtros').up('form').getForm();						
			           	var valoresForm = basicForm.getFieldValues();
	                   	var j=0;
				           for (j=0; j<aux_filtros.length; j++){
					           aux_params[''+aux_filtros[j].filter+''] = valoresForm[''+aux_filtros[j].name+''];
				        }
            	 		this.store.load({
            	 			params: aux_params,
            	 		});
   					          					
            	 	}
	        }], 
            layout: 'fit',
            emptyText: aux_empty,       
            store: aux_store,
            loadMask: true,
            columns:[],
            listener:{
           	 'sortchange': function( ct, column, direction, eOpts ){
	           		Ext.getCmp(aux_store).load({
						 params: aux_params,
					});
              	 }
            }
		 });
		
		var i = 0;	
		for (i=0; i<columns.length ; i++)
        {
			if (columns[i].tipo == '1'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,	
				});
			}
			else if (columns[i].tipo == '2'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,
			           renderer: columns[i].render,
				});
			} else if (columns[i].tipo == '3'){
				var aux_column = Ext.create('Ext.grid.column.Column', {
					   header: columns[i].text,
					   dataIndex: columns[i].dataIndex,
					   sortable: true,
	   	               align: columns[i].align,
			           flex: columns[i].flex,
			           renderer: columns[i].render,
			           summaryType: columns[i].summary_t,
			           summaryRenderer: columns[i].summary_r,
				});
			}
			grilla.headerCt.insert(i, aux_column);
        }
		
		return grilla;	
}