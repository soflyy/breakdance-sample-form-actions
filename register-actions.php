<?php

// register-actions.php included by your plugin

add_action('init', function() {
    // fail if Breakdance is not installed and available
    if (!function_exists('\Breakdance\Forms\Actions\registerAction') || !class_exists('\Breakdance\Forms\Actions\Action')) {
        return;
    }

    require_once('actions/FileLog.php');

    \Breakdance\Forms\Actions\registerAction(new FileLog());
});
