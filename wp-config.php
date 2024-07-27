<?php
define( 'WP_CACHE', false ); // By Speed Optimizer by SiteGround

// ** MySQL settings ** //
define( 'DB_NAME', 'wordpress' ); // The name of the database
define( 'DB_USER', 'root2' ); // Your MySQL username
define( 'DB_PASSWORD', 'BEngn$#09DDbWWM5&G' ); // Your MySQL password
define( 'DB_HOST', 'localhost' ); // 99% chance you won't need to change this value

// ** Database charset and collation ** //
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ** Authentication unique keys and salts ** //
define( 'AUTH_KEY',         'e*20JndF%!x#v$Q&76uY;32p?|#M:1wP@a`L|z>k#n,v+>%dNOH-p&I.g7[9WkGJ' );
define( 'SECURE_AUTH_KEY',  'JyxO-HbmXjI&5lZn%F1-2t)^i<Wk?Vv3J:bW@R_p7cGkZ/%B$Vt0SvX;MPU>+A9S' );
define( 'LOGGED_IN_KEY',    'ROq&yNkWo@esF}>&r~cFhRqu|(N43C*J(9n/dR<K6X#d6S_dCHcU$MI->,@-1I}r' );
define( 'NONCE_KEY',        'H#X.:S~S|#tEKn|e5o]y]Z+W7$~4xV1OxB_=x|;}/iIVc-e]2iD<ndGH2i]D:m-u' );
define( 'AUTH_SALT',        'I5xS0K~YXH_r]*Y:hx@(u>`!bPXndUezl+7(Rt6f,vgA8>VYZ1tLk|^Vv?$(?si@' );
define( 'SECURE_AUTH_SALT', '6b;5&l(w)R*hB>+^Sg`v>1r!8eFF[T1bHD:pK28W2$+vL~eR-7L]m^aN>*:~0quL' );
define( 'LOGGED_IN_SALT',   '|*Rb-rK#Gpi7@(!4ONY$nsISz5OW`+&[ErA%J#uEJAM|~`cQ.)m-E@LoN|Tn*WZ9' );
define( 'NONCE_SALT',       'K9Tb:ez2?4W45vQjPzRBME$XkMf|1y8O2?LhV?+=P1cC+-Sx9BrMhzpQ)&[M~]qa' );

// ** Table prefix ** //
$table_prefix = 'wp_'; // Only numbers, letters, and underscores please!

// ** Debug mode ** //
define( 'WP_DEBUG', false );

// ** Absolute path to the WordPress directory ** //
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

// ** Sets up WordPress vars and included files ** //
require_once(ABSPATH . 'wp-settings.php');
