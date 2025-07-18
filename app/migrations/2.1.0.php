<?php 

if(!defined('URL')) {
  die();
}

/**
 * Nuevas columnas para poder tener control de impuestos y publicación para tienda en línea
 * 
 * Nuevas columnas para retenciones de impuestos
 */
$changes['2.1.0'] = 
[
  'ALTER TABLE shippr_zonas ADD COLUMN tipo_servicio VARCHAR(255) NULL DEFAULT NULL AFTER cp'
];

return $changes;