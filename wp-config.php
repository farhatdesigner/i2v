<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'i2v' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ef[QnygS6oTRi&GG8NGQOlYOb2({0#aZ )6_P?<xE-GLHGI}j62jYY&QRjkTX+<{' );
define( 'SECURE_AUTH_KEY',  'HhrysSgr}Ypi,L(pefpUwt>W6Zig%tbRS>Fxj? :B064~hd28fGz;! V_N]G$iZP' );
define( 'LOGGED_IN_KEY',    'r#<[qk%>?2W/jfuo.f#AX4.}$pWnN!_{tS;Y|Vo>B,hVaY6kv/DpO2 #[U_^TEn.' );
define( 'NONCE_KEY',        'zz!Cd)B9R&] (!@lO.R.c?e),e3@38WQ78_p,zCg9k+toAf|AKinl,`8M.C8A<6Q' );
define( 'AUTH_SALT',        'cX6T7@Kz/Ehd@ 9{zT?ko02(nlXRDZ2d| v[22Tw&K)>$B5|R?oV94ewKs?c9aL)' );
define( 'SECURE_AUTH_SALT', 'z^Qh_x>u<q8vH,~bO26%|w<LoZUThZhB<d^tR:V9Q-R/Z{XfY#loA^b7{N(j:3 N' );
define( 'LOGGED_IN_SALT',   'Jx]b/15..[!fw-lY4ECh#gQ|g[_YIn_G4}U;>wsXM,{w%+rlTk>[w28FQ=Vu*3IE' );
define( 'NONCE_SALT',       'E09f1#?V/3^jee0M5(372:jSuecqzt_+7jb3qsdUcXeW@GU}B-M7v6#-/_pLi+T5' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
