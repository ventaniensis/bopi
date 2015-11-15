var page = new WebPage(), testindex = 0, loadInProgress = false;

var system = require('system');
var env = system.env;

var system = require('system');
var args = system.args;

window.fecha = args[3] + "-" + args[2] + "-" + args[1];

page.onConsoleMessage = function(msg) {
  console.log(msg);
};

page.onLoadStarted = function() {
  loadInProgress = true;
//  console.log("load started");
};

page.onLoadFinished = function() {
  loadInProgress = false;
  //console.log("load finished");
};

function evaluate(page, func) {
    var args = [].slice.call(arguments, 2);
    var fn = "function() { return (" + func.toString() + ").apply(this, " + JSON.stringify(args) + ");}";
    return page.evaluate(fn);
}

var steps = [
  function() {
    page.settings.userAgent = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.6 Safari/537.11";
    page.open("https://sede.oepm.gob.es/bopiweb/descargaPublicaciones/resultBusqueda.action");
  },
  function() {
   //console.log("Enter Credentials");
   //console.log(window.fecha);
   page.injectJs("jquery.min.js");
   evaluate(page, function(fecha) {
		 $('#fechaPublicacion').val(fecha);
   }, window.fecha);
   
  },
  function() {
   //console.log('submit');
   page.evaluate(function() {
     $('#resultBusqueda').submit();
   });
  },
  function() {
   page.evaluate(function() {
     //console.log(document.getElementById('contenidotomo2').outerHTML);
     var encontrado = document.getElementById('contenidotomo2').outerHTML.indexOf('descargaDoc') > 0;
   	 console.log(encontrado ? 'RECORD' : 'EMPTY');
   });
  }
]

interval = setInterval(function() {
  if (!loadInProgress && typeof steps[testindex] == "function") {
    //console.log("step " + (testindex + 1));
    steps[testindex]();
    //page.render("images/step" + (testindex + 1) + ".png");
    testindex++;
  }
  if (typeof steps[testindex] != "function") {
    phantom.exit();
  }
}, 50);