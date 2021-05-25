<?php
namespace Translation;

use Locale;
use Laminas\I18n\Translator\TranslatorServiceFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\I18n\View\Helper as I18nHelper;

return [
    'translator' => [
        //*** TRANSLATION LAB: configure the default locale and translation file patterns
        'locale' => 'en',
        'translation_file_patterns' => [
            [
                'type'     => ???,
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
    'service_manager' => [
        //*** TRANSLATION LAB: define a factory using the recognized service name "MvcTranslator"
        'factories' => [
            // ???
        ],
        //*** TRANSLATION LAB: define an alias "translator" to the translation service
        'aliases' => [
            // ???
        ],
        'services' => [
            'translation-supported' => [
                'de' => 'Deutsch',
                'en' => 'English',
                'es' => 'Español',
                'fr' => 'Français',
            ],
        ],
    ],
    'listeners' => [
        //*** TRANSLATION LAB: register the listener aggregate as a service here
    ],
    'view_helpers' => [
        //*** I18N LAB: set up the DateFormat and CurrencyFormat view helpers services
        'factories' => [
            // ???
        ],
        //*** I18N LAB: set up the DateFormat and CurrencyFormat view helper aliases to be used in view scripts
        'aliases' => [
            // ???
        ],
    ],
];
