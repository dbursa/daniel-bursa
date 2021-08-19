<?php

return [
    /**
     * Application variables, set-up what you need here
     */
    'multilanguage' => true,
    'usingDatabase' => false,
    'usingMailer' => false,
    'usingTrelloCms' => false,
    'templateCache' => false,
    'usingCors' => true, // Remember to fill domain below if using this setting
    'domain' => '<domain>', // This is required if you set usingCors! example: https://mywebsite.com
    
    /** App variables */
    'app_name' => 'phi-skeleton',
    'default_locale' => 'cs',

    /**
     * DATABASE
     */
    'dbDriver' => $_ENV['DB_DRIVER'],
    'dbHost' => $_ENV['DB_HOST'],
    'dbUsername' => $_ENV['DB_USERNAME'],
    'dbPassword' => $_ENV['DB_PASSWORD'],
    'dbDatabase' => $_ENV['DB_DATABASE'],

    /**
     * MAILER
     */
    'smtpHost' => $_ENV['SMTP_HOST'],
    'smtpPort' => $_ENV['SMTP_PORT'],
    'smtpUsername' => $_ENV['SMTP_USERNAME'],
    'smtpPassword' => $_ENV['SMTP_PASSWORD'],

    /**
     * Slim Settings
     */
    'settings' => [
        'displayErrorDetails' => true
    ],

];
