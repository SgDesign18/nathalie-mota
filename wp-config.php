<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'nathalie-mota' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Z?l7kM%;W9TG)-y{EO 6MC bvsaQcLA`|GMjm#+gXZze?b!|{:pD4tU~uVwp=L7|' );
define( 'SECURE_AUTH_KEY',  '[Xrd<g8o^z-#^K,)uCIU)<yRMDk2K)(@w g.M8LHCbG$Asmw6#Rq#:[SxfHf8bK>' );
define( 'LOGGED_IN_KEY',    ',Q ExO]?}]kG rye;S{:mfzo@zTU7#T5SXk]=EHK2!+BJ1>0l3U5wH7=:D?>Gou.' );
define( 'NONCE_KEY',        'z<SdM2$k%!bYJxNe/ChWz*?mtZ_=Bl@kiYVTrUI+C}C}~w.6~7E]mj|_7T8Rd!5(' );
define( 'AUTH_SALT',        'j]ec*<.mICq#pxa{o&pKzbD/+i~7NeJk$eC8 7wLcoJzE_PbaoZ{2Zopy(4WsmTl' );
define( 'SECURE_AUTH_SALT', 'AZ}>W@6D[Vu+sj;n*(KsS=SK+BgKN`1Uzj.[uX(W3Ebf[Ow>@VY{S]nK~;v-#nK+' );
define( 'LOGGED_IN_SALT',   'c6FL:9t/h1s?0F?+#Y>W jnWp:_FQsxgclwuJil!~}.Jo. (PpgC`,08bhh4buBL' );
define( 'NONCE_SALT',       'J`i}Mb]iwEY-+FY@+<tbH4oHL!e.B-iNs^B;cipM0[V2 y DM*+^?ririj_CKFHS' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs et développeuses d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', false);


/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
