<?php

/**
 * Centralised mail configuration for portfolio contact form.
 * Reads the sensitive SMTP password from password.env in the project root.
 */

// Base paths
$projectRoot = dirname(__DIR__);
$envPath     = $projectRoot . DIRECTORY_SEPARATOR . 'password.env';

// Default: no password loaded yet
$smtpPassword = null;

if (is_file($envPath)) {
    $envLine = trim(file_get_contents($envPath));

    if ($envLine !== '') {
        if (strpos($envLine, '=') !== false) {
            // Expected format: SMTP_PASSWORD=actual_password_here
            [$envKey, $envVal] = explode('=', $envLine, 2);
            if (trim($envKey) === 'SMTP_PASSWORD') {
                $smtpPassword = trim($envVal);
            }
        } else {
            // Backwards compatibility: support a single raw password line
            $smtpPassword = $envLine;
        }
    }
}

return [
    'host'       => 'smtp.gmail.com',
    'username'   => 'weihao.lee.works@gmail.com',
    'password'   => $smtpPassword,
    'port'       => 587,
    'from_email' => 'weihao.lee.works@gmail.com',
    'from_name'  => 'Weihao Lee | Portfolio',
];

