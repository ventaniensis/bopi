#!/bin/bash
# Dump productos marcas
php process-csv.php ../out/marcas.solicitudes.txt year,month,day,PUBLICACIONID,P21_NUMSOLICITUD,PRODUCTOSSERVICIOSACTIVIDADES >../out/marcas.productos.txt
php process-csv.php ../out/nombres_comerciales.solicitudes.txt year,month,day,PUBLICACIONID,P21_NUMSOLICITUD,PRODUCTOSSERVICIOSACTIVIDADES,DENOMINACION >../out/nombres_comerciales.productos.txt

php process-csv.php ../out/nombres_comerciales.solicitudes.txt year,month,day,PUBLICACIONID,P21_NUMSOLICITUD,PRODUCTOSSERVICIOSACTIVIDADES,DENOMINACION >../out/nombres_comerciales.productos.txt

