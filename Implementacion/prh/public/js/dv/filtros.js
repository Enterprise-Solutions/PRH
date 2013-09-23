function createFiltroBusqueda (aux_height, filtros, aux_grid, aux_store, aux_params)
{
		var filtro_busqueda = Ext.create('Ext.form.Panel', {
			 type:  'hbox',
			 collapsible: true,
			 title:'Filtros de B&uacute;squeda',
			    width: 'fit',	
			    height:'fit',			           
			    items:[
				{
				    xtype: 'container',
				    id: 'filtros',
				    height: aux_height,
				    layout:'column',
				    items:[]
					},{
						xtype: 'container',
					    height: 40,
					    layout:'hbox',
					    items:[{
			
				           		xtype: 'button',
				           		width: 100,
				           		margin: '0 0 0 20',
				            	text: 'Filtrar',
					            scale   : 'medium',
					            handler: function(b,e) {
					            	
							           var basicForm = b.up('form').getForm();						
							           var valoresForm = basicForm.getFieldValues();
							           var j=0;
							           for (j=0; j<filtros.length; j++){
								           aux_params[''+filtros[j].filter+''] = valoresForm[''+filtros[j].name+''];
							           }			
							           	page = 0;
							           	Ext.getCmp(aux_grid).currentPage = 1;
							           	Ext.getCmp(aux_grid).store.load(
									        {
												params: aux_params, 
							               	}
							            );
						            }
									        
								},{	
						  		xtype: 'button',
						  		width: 100,
						  		margin: '0 0 0 15',
			               		text: 'Limpiar',
				           		scale   : 'medium',
				           		handler: function(b,e) {
				           			//inicializo los pages
						           	page = 0;
									console.log(aux_grid);
									Ext.getCmp(aux_grid).currentPage = 1;
				           			b.up('form').getForm().reset();
				           			Ext.getCmp(aux_grid).store.load();	           			
				           		}
								}]}
				    	]
		});
		
		var i = 0;
		
		for (i=0; i<filtros.length ; i++)
        {
			if (filtros[i].tipo == '1'){
				var aux_filtro = Ext.create('Ext.form.TextField', {
					fieldLabel: filtros[i].nombre,
				    labelWidth: filtros[i].label,
			        width: filtros[i].width,
				  //  width: 370,
				    anchor:'90%',
				    padding: '10 0 0 25',
				    name: filtros[i].name,
				});
			}else if (filtros[i].tipo == '2') {		
				var aux_filtro = Ext.create('Ext.form.ComboBox', {
					fieldLabel: filtros[i].nombre,
			        labelWidth: filtros[i].label,
			        padding: '10 0 0 25',
			        anchor:'90%',
			        width: filtros[i].width,
			        store: filtros[i].store,
			        displayField: filtros[i].display,
			        valueField: filtros[i].value,
			        //emptyText: 'Escriba el Tipo de Contacto...',
			        queryMode: 'local',    
			        name: filtros[i].name,
			  	});
			} else if (filtros[i].tipo == '3') {
				var aux_filtro = Ext.create('Ext.form.field.ComboBox', {
			        fieldLabel: filtros[i].nombre,
			        displayField: filtros[i].display,
			        valueField: filtros[i].value,
			        name: filtros[i].name,
			        width: filtros[i].width,
			        labelWidth: filtros[i].label,
			        store: filtros[i].store,
			        queryMode: 'remote',
			        padding: '10 0 0 25',
			        typeAhead: true,
			        anchor:'90%',
			        loadingText: 'Buscando...',
			        hideTrigger: true,
			        queryParam: filtros[i].query,
			        minChars: 1,
				});	
			}
			Ext.getCmp('filtros').add(aux_filtro);
        }
		return filtro_busqueda;
	
}