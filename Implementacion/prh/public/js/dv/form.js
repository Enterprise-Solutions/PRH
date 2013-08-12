function createCombo (aux_label, aux_label_w, aux_width, aux_store, aux_display, 
					aux_value, aux_query, aux_padding, aux_anchor, aux_name)
{
		return new Ext.create('Ext.form.field.ComboBox', {
			fieldLabel: aux_label,
	        xtype: 'combobox',
	        labelWidth: aux_label_w,
	        width: aux_width,
	        store: aux_store,
	        displayField: aux_display,
	        valueField: 'act_nivel_id',
	        queryMode: aux_query,      
	        padding: aux_padding,
 	        anchor:aux_anchor,
 	        name: aux_name,
	  	});
	
}