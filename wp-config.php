<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'i7000266_adc');

/** Deshabilito WP_CRON */
define('DISABLE_WP_CRON', true);

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '+{{(/0+;]r(c[ImY.O5Dw@_]8D H>!N,h4gf7@gl?}QO_*hyIp9-S(lvG1_1qI[b');
define('SECURE_AUTH_KEY', '+TVO|-qXiC8IQ sKiec#G)]L)QELu(VClKtR@?T!5MA7&p5eX0@[l[jOTQ7?|8w)');
define('LOGGED_IN_KEY', '^GV,j;xtq?P8g3}|`hvl3-t=@M^&*()6n~dGc(N~$t$HL8B}]gV-/IE}.#3|f9?L');
define('NONCE_KEY', 'KSlaN[p#w`+y<Wc<F$Kl`+8E6R-Y-U}uFnSrv1I-mbwX@ZvVtZUT+9Y|?|aW+d&b');
define('AUTH_SALT', 'fz]?BhxbUI20*XSXh.|qz6:n#j<AGcR]a|voeV :2de#qSa{}&K@,h6QmO;*-<^$');
define('SECURE_AUTH_SALT', '1l}eQoBqXJIlAyZ{|HM,8FtoSrK>NL+lO*UNmC^Cx+z=+eASLqq#-+.1$SplCxt{');
define('LOGGED_IN_SALT', 't3jdZvULn3.Q O j(aa{&2fN<dd?P7-?6^.u<yNtA?$:g-Vc`h>(J+&7xa_Dw`BN');
define('NONCE_SALT', ',C8eieFOEcK:7Z]b7BK+VgN:^OY+A9j=4GNjN|l63I:_.}1vm!+K*ig}1Z~_IQ`J');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

