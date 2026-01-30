function comprobar_sesion_cerrada(str){

	if(str.indexOf("<title>")>0)
	    document.location='signin.php?error=2';
}


function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    // separa en parte entera cada 3 y parte decimal usando el punto
    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

	// separa en parte entera que separo cada 3 los une con la come como sep de miles
    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    //une entera con decimal usando un punto
    return amount_parts.join('.');
}



