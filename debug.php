<?php
/**
 * Plugin Name: Debug
 * Description: Handy debugging functions.
 * Version: 2.0.1
 * Author: Česlav Przywara <cp@bluechip>
 * Author URI: http://www.bluechip.at
 */

namespace Debug;

/**
 * Print all passed arguments to error log, if WP_DEBUG is true: arrays and
 * objects are printed via print_r, any other type is printed via var_export
 * @param mixed $	Variable(s) you want to print to error log.
 */
function dump() {
	if ( true === WP_DEBUG ) {
		foreach (func_get_args() as $arg) {
			error_log((is_array($arg) || is_object($arg)) ? print_r($arg, true) : var_export($arg, true));
		}
	}
}


/**
 * Print backtrace to error log, if WP_DEBUG is true.
 * @link http://php.net/manual/en/function.debug-print-backtrace.php#92542
 */
function backtrace() {
	if ( true === WP_DEBUG ) {
		$e = new \Exception();
		error_log(PHP_EOL . $e->getTraceAsString());
	}
}
