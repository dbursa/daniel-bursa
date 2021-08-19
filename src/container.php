<?php

use Dibi\Connection;
use Slim\Views\Twig;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Bridge\Twig\Extension\TranslationExtension;

/*************************************
 * Set all dependencies into container
 * in this file
 */


/**
 * Translations
 */
if ($container->get('config')['multilanguage']){
    $container->set('trans', function() use ($app) {
        $container = $app->getContainer();

        $translator = new Translator($container->get('config')['default_locale']);
        $translator->addLoader('php', new PhpFileLoader());
        $translator->setFallbackLocales([$container->get('config')['default_locale']]);
        /**
         * Sets language based on app locale
         */
        if (isset($_SESSION['app_locale'])){
            $translator->setLocale($_SESSION['app_locale']);
        }
        /**
         * Get all available languages and insert into container
         * Then loop through them and register it's strings.php files to translator
         */
        $container->set('available_locales', function() {
            $scanned_directory = array_values(array_diff(scandir('../resources/lang'), array('..', '.')));

            return $scanned_directory;
        });
        
        $container->set('app_locale', function() use ($app) {
            $container = $app->getContainer();
            
            if (isset($_SESSION['app_locale'])){
                return $_SESSION['app_locale'];
            }else {
                return $container->get('config')['default_locale'];
            }
        });

        /**
         * Register all language strings
         */
        foreach ($container->get('available_locales') as $locale){
            $path = "../resources/lang/$locale/strings.php";
            $translator->addResource('php', $path, $locale);
        }

        return $translator;
    });
}


/**
 * Set path to twig views and enable / disable cache
 * 
 */
$container->set('view', function() use ($app) {
    $container = $app->getContainer();
    $twig = ($container->get('config')['templateCache']) ? 
        Twig::create('../resources/views', ['cache' => 'cache/']) : 
        Twig::create('../resources/views', ['cache' => false]);

    if ($container->get('config')['multilanguage']){
        $twig->addExtension(new TranslationExtension($container->get('trans')));
        $twig->getEnvironment()->addGlobal('app_locale',$container->get('app_locale')); 
        $twig->getEnvironment()->addGlobal('available_locales',$container->get('available_locales')); 
    }

    return $twig;
});

/**
 * If database enabled, put instance of
 * Dibi into container
 */
$container->set('db', function() use ($app) {
    $container = $app->getContainer();
    $config = $container->get('config');

    if ($container->get('config')['usingDatabase'])
    {
        return new Connection([
            'driver' => $config['dbDriver'],
            'host' => $config['dbHost'],
            'username' => $config['dbUsername'],
            'password' => $config['dbPassword'],
            'database' => $config['dbDatabase'],
        ]);
    }else {
        return null;
    }
});

/**
 * If emails enabled, put instance of
 * swiftmailer into container
 */
$container->set('mailer', function() use ($app) {
    $container = $app->getContainer();
    $config = $container->get('config');

    if ($container->get('config')['usingMailer'])
    {
        $transport = (new Swift_SmtpTransport($config['smtpHost'], $config['smtpPort'], 'tls'))
        ->setUsername($config['smtpUsername'])
        ->setPassword($config['smtpPassword']);
        $mailer = new Swift_Mailer($transport);
        return $mailer;
    }else{
        return null;
    }
});