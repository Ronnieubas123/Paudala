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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'paudala' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'd.>>-a[e{lMC.qy4yDt/LsmhX*FHNB.e7wG*LXkze^b=n5aa6Ub4*3OwXk?W-vCP' );
define( 'SECURE_AUTH_KEY',  'HSB2|ak&FL5SaOSuPnB!1oC`e{ N[v[gesApV:>O}dUiE-rrNh>JEow)y99pHLhK' );
define( 'LOGGED_IN_KEY',    '${Fzoth!v:/Zi9ArYZI{B3O+GZNbZ^JP%bu%JCq,w?(wFM=;6vIUvr~T%jP;&3~ ' );
define( 'NONCE_KEY',        'TAt74O,oN~Ct^K`t&d@qT)A+ /s=rrwZXg$%}>_%p5EY*`Tt;Gd_Y!$PwNJp4ODq' );
define( 'AUTH_SALT',        'v,~I%J 1AS;#PmYi8`s(9M;K17[cwCHMl_/]^BKMdob(&A&+Z78/I(^<T6$I]th0' );
define( 'SECURE_AUTH_SALT', 'XbdCfiXUB(R{,+A.~^G<lz$z6j<kRGL?3WUcKv=6cpE)~r[fWMMqZ^Q;NvR`-f9h' );
define( 'LOGGED_IN_SALT',   'zjk~sHr=`E*uEes}J11{c`t`DlMB[K0o7B&-SVixJq`gT.}+ZKEes_:](aO:tPWP' );
define( 'NONCE_SALT',       'i[am2<_x-B#A%T$U1[I!]FT>1fKZ$Ii_{gxMk@ORPcIb17pQqPP0`,^Tt-`eMkhd' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
