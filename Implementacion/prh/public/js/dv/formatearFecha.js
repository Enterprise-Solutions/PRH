
function formatearFecha(date, formato)
{
	if(!date)
		return null;
	
	var fecha;

	switch(formato)
	{
		//dd-mm-yyyy
		case 1:
			fecha = date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
			break;
		case 2:{
				var aux_fecha = date;
		    	var fecha2 = aux_fecha.split("-");
		    	fecha = fecha2[2]+'-'+fecha2[1]+'-'+fecha2[0];
		break;
		}
	}
	
	return fecha;
}