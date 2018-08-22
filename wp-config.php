<?php
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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'ceriel');

/** MySQL database password */
define('DB_PASSWORD', '0901CLF1992!!1465');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$684@PHtH S2OTA+VW;ZauakT%ao0;zKMh0BHC~m=]w{*,M3AGV!MgAQW.qK~LO&');
define('SECURE_AUTH_KEY',  '? `hiKGpO$G7hUs>3Pv@J}b3~pJ47de4!cVmQy2 +ga+A>j0W6C~hL`@rL*S$CuJ');
define('LOGGED_IN_KEY',    '`r-W1}gy&b9;NK`D6MRRm5)imPO^X~hO )O;Rbt5S+1rI^A1&)wLPK|uG[ok}`W~');
define('NONCE_KEY',        'FDhR_iJZ%],/ F*DmI a0 u| 5(yD[0%SE/@#xw)Qz3-tF1l&9azRs6HySLWF{t:');
define('AUTH_SALT',        'fXz+,DX*x (Q9qUo$yl2)~l(HNv*C.j+9D{.SXD/bxAHE>+0P+ea!Pqa^t`%C/rs');
define('SECURE_AUTH_SALT', 'O/`^oX6&qIm}r_qI{.:%f=WPIvK8v4:a=r+PvZ*2nWV(~;$?31Jj=F//R9BGK8fy');
define('LOGGED_IN_SALT',   ']J-pY`%qw`)*OVEoAC-G4PD<XX9kADJ1rq[DQ&tav#WCJ!Gw`oJTU]k%MveA0tnv');
define('NONCE_SALT',       'YZ#8#60,.=!WGdwEBbG*~y F%3nrQ N~*HpPWeS)GXq].KazCeH9yVL.]j`|+T i');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
