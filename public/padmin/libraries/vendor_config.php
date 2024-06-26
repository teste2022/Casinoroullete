<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * File for vendor customisation, you can change here paths or some behaviour,
 * which vendors such as Linux distributions might want to change.
 *
 * For changing this file you should know what you are doing. For this reason
 * options here are not part of normal configuration.
 *
 * @package PhpMyAdmin
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * Path to changelog file, can be gzip compressed. Useful when you want to
 * have documentation somewhere else, eg. /usr/share/doc.
 */
define('CHANGELOG_FILE', '/usr/share/doc/phpmyadmin/changelog.gz');

/**
 * Path to license file. Useful when you want to have documentation somewhere
 * else, eg. /usr/share/doc.
 */
define('LICENSE_FILE', '/usr/share/doc/phpmyadmin/copyright');

/**
 * Path to config file generated using setup script.
 */
define('SETUP_CONFIG_FILE', '/var/lib/phpmyadmin/config.inc.php');

/**
 * Whether setup requires writable directory where config
 * file will be generated.
 */
define('SETUP_DIR_WRITABLE', false);

/**
 * Directory where SQL scripts to create/upgrade configuration storage reside.
 */
define('SQL_DIR', './sql/');

/**
 * Directory where configuration files are stored.
 * It is not used directly in code, just a convenient
 * define used further in this file.
 */
define('CONFIG_DIR', '/etc/phpmyadmin/');

/**
 * Filename of a configuration file.
 */
define('CONFIG_FILE', CONFIG_DIR . 'config.inc.php');

/**
 * Filename of custom header file.
 */
define('CUSTOM_HEADER_FILE', CONFIG_DIR . 'config.header.inc.php');

/**
 * Filename of custom footer file.
 */
define('CUSTOM_FOOTER_FILE', CONFIG_DIR . 'config.footer.inc.php');

/**
 * Default value for check for version upgrades.
 */
define('VERSION_CHECK_DEFAULT', false);

/**
 * Path to gettext.inc file. Useful when you want php-gettext somewhere else,
 * eg. /usr/share/php/gettext/gettext.inc.
 */
define('GETTEXT_INC', '/usr/share/php/php-gettext/gettext.inc');
/**
 * Path to tcpdf.php file. Useful when you want to use system tcpdf,
 * eg. /usr/share/php/tcpdf/tcpdf.php.
 */
define('TCPDF_INC', '/usr/share/php/tcpdf/tcpdf.php');

/**
 * Path to the phpseclib. Useful when you want to use system phpseclib.
 */
define('PHPSECLIB_INC_DIR', '/usr/share/php/phpseclib/');

/**
 * Path to the udan11/sql-parser. Useful when you want to use system version.
 */
define('SQL_PARSER_AUTOLOAD', './libraries/sql-parser/autoload.php');

/**
 * Avoid referring to nonexistent files (causes warnings when open_basedir
 * is used)
 */
define('K_PATH_IMAGES', '');
