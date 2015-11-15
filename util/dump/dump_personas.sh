#!/bin/bash
# ------------------------------------------------------------
# Dump Personas distintas nombres comerciales
# ------------------------------------------------------------
php process-csv.php ../out/nombres_comerciales.solicitudes.txt year,month,day,PUBLICACIONID,P21_NUMSOLICITUD,nombretitular,apellidostitular,Domicilio,CodigoPostal,PaisDeResidencia,Localidad,Provincia,DENOMINACION >../out/personas.nombres_comerciales.txt
# ------------------------------------------------------------
# Dump Personas distintas marcas
# ------------------------------------------------------------
php process-csv.php ../out/marcas.solicitudes.txt year,month,day,PUBLICACIONID,P21_NUMSOLICITUD,nombretitular,apellidostitular,Domicilio,CodigoPostal,PaisDeResidencia,Localidad,Provincia >../out/personas.marcas.txt
