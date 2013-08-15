function createStore (aux_model, baseURL, aux_url, aux_params)
{
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		proxy: {
			type: 'ajax',
			extraParams: {'p[limit]':'all'},
			headers: aux_params,
			url: baseURL+aux_url,
			reader: {
				type: 'json',
				root: 'records'
			}
		},
		autoLoad: true
	});	
}

function createStorePage (aux_model, baseURL, aux_url, aux_page, aux_size)
{	
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		pageSize: aux_size, 
		proxy: {
			type: 'ajax',
			headers: {'p[limit]':aux_size,'p[page]':aux_page},
			url: baseURL+aux_url,
			reader: {
				type: 'json',
				root: 'records',
				totalProperty: 'numResults'
			}
		},
		autoLoad: true
	});	
}