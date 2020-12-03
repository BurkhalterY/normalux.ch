<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Ratchet Websocket Library: config file
 * @author Romain GALLIEN <romaingallien.rg@gmail.com>
 * @var array
 */
$config['ratchet_client'] = array(
	'host' => '0.0.0.0',	// Default host
	'port' => 8080,			// Default port (be carrefull to set unused server port)
	'auth' => false,		// If authentication is mandatory
	'debug' => true			// Better to set as false in Production
);