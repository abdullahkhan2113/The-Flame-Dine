<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'The Flames Dine' );

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
define( 'AUTH_KEY',         '$RNzEpD)T&]>;W[$dr,!7z9xA16a<ZKnimsyw64>N)Eqzt<jNBn7}fWJMn.5UxYS' );
define( 'SECURE_AUTH_KEY',  ';j:t(:>j+IEi*t!nf<Cf%#]).-QJ_nCJ.Cu}dMuWitR;T0)q7Q{WHV_k+<7aT/XD' );
define( 'LOGGED_IN_KEY',    '2)ZY61kJj)1Uw@ZStB-!ovA`PA~b@Ey:8XQ:|i{wS~zR$QHV*{{?N7)Pr^oO%jVc' );
define( 'NONCE_KEY',        '`xBAMDP8CeTu67C2fU^e=O6Ux{/{BW<9nf!vfvm-AHP~(g!v={P7tk(`bPHSV1l)' );
define( 'AUTH_SALT',        'v^Ht!0|hQ6F&,9CT< Aoi+DUe|f9[6rU{7h1rleYVn|Jqan:C2[Tg _%G :ty3_G' );
define( 'SECURE_AUTH_SALT', 'xkHpxcn67uk*_1({B;=t!49PuE82=kL~ A!ls-|[W#jPz|UL2y,;47?mFK@>[_pY' );
define( 'LOGGED_IN_SALT',   '$GdFBIY%f<HhKYRPiJE&=675G9noEIk-<naT0,T[h`-n,D9b_v051U)}WC|LU%xK' );
define( 'NONCE_SALT',       'W1;lXP-6my@eV&/{`MGI!oKKi0L>l]}.9EuHcirbF$9aI;a57l6}Uk~lfst? Yo;' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
