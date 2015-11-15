var page = require('webpage').create();

page.open('https://sede.oepm.gob.es/bopiweb/descargaPublicaciones/resultBusqueda.action', function(status) {

if (status !== 'success') 
  {
    console.log('Unable to access network ' + status);
  } else 
  {
	  page.evaluate(function () 
	  {
	      document.getElementById("resultBusqueda").elements['fechaPublicacion'].value = '04-02-2015';
	      //documen.render('bopi.png');
	  	
	      console.log('SALIDA');

	      document.getElementById("resultBusqueda").submit();		  

	      return '';
	  });
*/	  
    //console.log(ua);
  }
  phantom.exit();
});