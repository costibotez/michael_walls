<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_michael_walls' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Z2[)u<dTEbV1zl=(,=d!%M0u$c[F)L].3$Jyk(*8jYBG*`t.`q~0>nEIg6{0]]?=' );
define( 'SECURE_AUTH_KEY',  'e<U$Y@, 4:D{)v1IJ*`dhp;y+#UE_+Whb)%%~MR/(dQ!77=m7qf8),7QfIA:rPSJ' );
define( 'LOGGED_IN_KEY',    'QP,+6Le5[yaw;6N~r)),!>PD_;9&+9f:Dw`J%Y/wZ/p!bY}ER^9]:C)5fS6W0mhB' );
define( 'NONCE_KEY',        ')<nU4>igM%--YO[h Oaxf*:l[G{KPD@AaLF:fn=yRPq[mD{LZdG=nmt*:c$;#q5J' );
define( 'AUTH_SALT',        'A^.owAp_UD#vPrK:*E4l/r%UL+$%xnxa!SYmHfi~q.}hdh%bpRR}2*Qg~v%i`!K#' );
define( 'SECURE_AUTH_SALT', 'N>Z`]S0S7m}T/#m`FM2.&.K1i+gQ)$/y9ZL,8Qv,e6}LGWD/(}kj! 5^/W0Jc!la' );
define( 'LOGGED_IN_SALT',   '1CT<l+z+[4}%(@Jv!$m3zfE4Y|.e]K6<,FVTPRl]I{?&T]K3?iLS<b<Q6},$snj)' );
define( 'NONCE_SALT',       'zkG<5NqwLtPH^%-,zEne@ZL,M{ooxoej~a(m(Vz<s:QZ|w=m9FH@SM_1ap78&]S ' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

// define('WP_DEBUG', true);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
