function buscarId ()
{
	if (window.location.hash) {
	    var params = (window.location.hash.substr(1)).split("#");
	        var id = params[0].split("=");
			return id[1];
	}
}