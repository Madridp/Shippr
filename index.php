<?php 
/*
Archivo príncipal para cargar el sitio
basado en el patrón MVC

@access public
@param controller
@param model
@param values

Versión: 1.0.0
*/
//error_reporting(E_ALL);

require "app/core/Bootstrap.php";

/*
Main method to run all the website
*/
Bootstrap::run();

