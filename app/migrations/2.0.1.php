<?php 

if(!defined('URL')) {
  die();
}

/**
 * Nuevas columnas para poder tener control de impuestos y publicación para tienda en línea
 * 
 * Nuevas columnas para retenciones de impuestos
 */
$changes['2.0.1'] = 
[
  'ALTER TABLE shippr_transacciones ADD COLUMN tipo_ref VARCHAR(255) NULL DEFAULT NULL AFTER id_usuario'
];

return $changes;