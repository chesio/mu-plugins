<?php
/**
 * Plugin Name: Environment Plugin Disabler
 * Description: Disables plugins based on environment configuration.
 * Version: 20180701
 * Requires PHP: 7.0
 * Author: Česlav Przywara
 * Author URI: https://www.chesio.com
 * Plugin URI: https://github.com/chesio/mu-plugins
 * Inspired by: https://roots.io/guides/how-to-disable-plugins-on-certain-environments/
 */

if (defined('DISABLED_PLUGINS') && is_array(DISABLED_PLUGINS) && !empty(DISABLED_PLUGINS)) {
    // Single site
    add_filter('option_active_plugins', function (array $plugins): array {
        foreach (DISABLED_PLUGINS as $plugin_file) {
            $key = array_search($plugin_file, $plugins);
            if ($key !== false) {
                unset($plugins[$key]);
            }
        }
        return $plugins;
    }, 10, 1);

    // Multisite
    add_filter('site_option_active_sitewide_plugins', function (array $plugins): array {
        foreach (DISABLED_PLUGINS as $plugin_file) {
            if (isset($plugins[$plugin_file])) {
                unset($plugins[$plugin_file]);
            }
        }
        return $plugins;
    }, 10, 1);

    // Remove activation link from plugin actions and append a short notice instead.
    foreach (DISABLED_PLUGINS as $plugin_file) {
        add_filter("plugin_action_links_{$plugin_file}", function (array $actions): array {
            if (isset($actions['activate'])) {
                unset($actions['activate']);
            }
            $actions['disabled'] = esc_html('Plugin is disabled in current environment.', 'environment-plugin-disabler');
            return $actions;
        }, 10, 1);
    }
}
