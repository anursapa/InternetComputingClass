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
define( 'DB_NAME', 'omardb' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '123456' );

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
define( 'AUTH_KEY',         'o#bP8eoyzZ]IQ}Q^7g#`X<3u}+Ob=}3&=uz>w>.W=b=&G#?MZC sbUv;0]Z0Pq`d' );
define( 'SECURE_AUTH_KEY',  'k=w(!4zVKJ@ Svz .R6Dq&5NSCo6#Yl/VwXq^vv<$Kiy6KMs#1$Q2/Vt!`cRj>y!' );
define( 'LOGGED_IN_KEY',    '!SD8:)e5xj;TZA1<rk3G41+|30VZZ)HQr:)|A+vq[67PM}22-Knq_&*k.h2#/paZ' );
define( 'NONCE_KEY',        'Dw^FrStk!eG*5@B#BpnJ.?L;SEI+fXI!{U,Q0Mth(Wd-{S4WxkH#P7w=?-%c4S<q' );
define( 'AUTH_SALT',        '(+Ws^u(m.Bo3qZKKw~+KInr o>cs6is{=mnU9H)Y/3m~1U&|}3rCTj$}$8%#?A1P' );
define( 'SECURE_AUTH_SALT', 'sW,FavdSnI(!$Hn.&W]w1w[56_%ipIW<Y0^q6q|InRQLsMc;<cw4Z5QAF*,jkTw9' );
define( 'LOGGED_IN_SALT',   '{R- xjU?k_%rtO8Z+sx3-6-<alXS@c_%<lI7W6@u>I}LLSui$W2/*/oHrt.+B/J-' );
define( 'NONCE_SALT',       'Mu|. ]9>0S@aPek_s=_nIJipF?HH$pjRX@T.K$@+#D%gu3iF2-?-xyIe?w:x#U1[' );

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
