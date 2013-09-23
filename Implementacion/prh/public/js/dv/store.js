function createStore (aux_model, baseURL, aux_url, aux_load)
{
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		proxy: {
			type: 'ajax',
			extraParams: {'p[limit]':'all'},
			headers: {'Accept':'application/json'},
			url: baseURL+aux_url,
			reader: {
				type: 'json',
				root: 'records'
			}
		},
		autoLoad: aux_load
	});	
}

function createStoreFalse (aux_model, baseURL, aux_url, aux_params)
{
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		proxy: {
			type: 'ajax',
			extraParams: aux_params,
			headers: {'Accept':'application/json'},
			url: baseURL+aux_url,
			reader: {
				type: 'json',
				root: 'records'
			}
		},
		autoLoad: false
	});	
}

function createStorePage (aux_model, baseURL, aux_url, aux_size)
{	
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		pageSize: aux_size,
		remoteSort: true,
		proxy: {
			type: 'ajax',
			extraParams:{
		    	"p[limit]": aux_size,
				"p[page]": page,		        
			},
			simpleSortMode: true,
			sortParam: "sort[property]",
			directionParam: "sort[direction]",
			headers: {'Accept':'application/json'},
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

function createStorePageParams (aux_model, baseURL, aux_url, aux_size, aux_params)
{	
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		pageSize: aux_size,
		remoteSort: true,
		proxy: {
			type: 'ajax',
			extraParams: aux_params,
			simpleSortMode: true,
			sortParam: "sort[property]",
			directionParam: "sort[direction]",
			headers: {'Accept':'application/json'},
			url: baseURL+aux_url,
			reader: {
				type: 'json',
				root: 'records',
				totalProperty: 'numResults'
			}
		},
		autoLoad: false
	});	
}

function createStoreId (aux_model, baseURL, aux_url, aux_size, aux_id)
{	
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		pageSize: aux_size,
		remoteSort: true,
		proxy: {
			type: 'ajax',
			extraParams:{
		    	"p[limit]": aux_size,
				"p[page]": page,
				"s[id]": aux_id
			},
			simpleSortMode: true,
			sortParam: "sort[property]",
			directionParam: "sort[direction]",
			headers: {'Accept':'application/json'},
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

function createStoreGroup (aux_model, baseURL, aux_url, aux_params, aux_size, group)
{	
	return new Ext.create('Ext.data.Store', {
		model: aux_model,
		pageSize: aux_size,
		remoteSort: true,
//		remoteGroup: true,
		groupField: group,
//		startCollapsed: false, 
		proxy: {
			type: 'ajax',
			extraParams: {'p[limit]':'all'},
//			simpleGroupMode: true,
			simpleSortMode: true,
			sortParam: "sort[property]",
			directionParam: "sort[direction]",
			headers: aux_params,
			url: baseURL+aux_url,
			reader: {
				type: 'json',
				root: 'records',
				totalProperty: 'numResults'
			}
		},
		autoLoad: false
	});	
}