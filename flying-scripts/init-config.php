<?php

function flying_scripts_validate_timeout($value) {
    // Accept the settings menu choices, including 5000 for "Never".
    if ((is_int($value) || is_string($value)) && preg_match('/\A(?:[1-9]|10|5000)\z/', (string) $value)) {
        return (int) $value;
    }

    return null;
}

function flying_scripts_get_timeout() {
    $timeout = flying_scripts_validate_timeout(get_option('flying_scripts_timeout'));
    return $timeout === null ? 5 : $timeout;
}

function flying_scripts_save_timeout($value) {
    $timeout = flying_scripts_validate_timeout($value);
    if ($timeout !== null) {
        update_option('flying_scripts_timeout', $timeout);
    }
}

// Set default config on plugin load if not set
function flying_scripts_set_default_config() {

    if (FLYING_SCRIPTS_VERSION !== get_option('FLYING_SCRIPTS_VERSION')) {
        
        if (get_option('flying_scripts_timeout') === false)
            update_option('flying_scripts_timeout', 5);

        if (get_option('flying_scripts_include_list') === false)
            update_option('flying_scripts_include_list', []);

        if (get_option('flying_scripts_disabled_pages') === false)
            update_option('flying_scripts_disabled_pages', []);

        update_option('FLYING_SCRIPTS_VERSION', FLYING_SCRIPTS_VERSION);
    }
}

add_action('plugins_loaded', 'flying_scripts_set_default_config');
