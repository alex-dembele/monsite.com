<?php
//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings

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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'monsite' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'nexah' );

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
define( 'AUTH_KEY',         'kzn[Z7m_]59alb3LlH_XE2-1-zJKI|u}$.qPh!1:)5UZlsCuRm_(S`BV$0A>:czT' );
define( 'SECURE_AUTH_KEY',  'LQi[ddY4o3R1o8f9K*ph84V_WZpre5y@f%/UG<m_cA]Yl9I~f9_c,7}]u2ntynM)' );
define( 'LOGGED_IN_KEY',    'Q430.KAf.a7,*c1 #r.&mcd<>C<avK8>#mXSb|pj445tQ-%meK#k,^fiQ~Zfqk-<' );
define( 'NONCE_KEY',        'y&@q1=LER#=6Ltxe_^{9@<9x3o6$2QDpsye`Ost.hc3X`2DJMed3#7.96jO|5p]p' );
define( 'AUTH_SALT',        'uv@9?{u@?wl$>-jV~k|WNh,!EdCXM0.QKjF)g*>O-3{4+%8({.7zHxgVPNl*@qX3' );
define( 'SECURE_AUTH_SALT', '13=a`yMJy<8H6Ytte]gB<G}Q4s#bxeksga%$*SmA.gy;6=9uLiW>=?U!Q?bE.>2(' );
define( 'LOGGED_IN_SALT',   '7@, <TjCu1dbTA{2Y[oF?<U(SM>mf+<_JxP;fb(3OdNzoU|~#{S2[wZ<Q++RCg<a' );
define( 'NONCE_SALT',       'tXD)aB<Z[=eLx^Z#AT6Ivx]!I9Je|`|>S@.|>{Q*0B(E#+%8G==KM,G`RA1@I>47' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
