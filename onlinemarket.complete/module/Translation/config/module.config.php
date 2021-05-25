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
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'MvcTranslator' => TranslatorServiceFactory::class,
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
        Listener\TranslationListenerAggregate::class,
    ],
    //*** I18N LAB: set up the DateFormat and CurrencyFormat view helpers
    'view_helpers' => [
        'factories' => [
            I18nHelper\DateFormat::class => InvokableFactory::class,
            I18nHelper\CurrencyFormat::class => InvokableFactory::class,
        ],
        'aliases' => [
            'dateFormat' => I18nHelper\DateFormat::class,
            'currencyFormat' => I18nHelper\CurrencyFormat::class,
        ],
    ],
];
