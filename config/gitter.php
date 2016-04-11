<?php
use Interfaces\Gitter\Middleware\Storage;

return [
    'token'       => env('GITTER_TOKEN', null),

    'output'      => true,

    'rooms'       => [
        'debug'         => env('GITTER_DEBUG_ROOM', null), // Debug

        'laravel.chat'  => '52f9b90e5e986b0712ef6b9d',  // https://gitter.im/LaravelRUS/chat
        'laravel.site'  => '54053e51163965c9bc201c26',  // https://gitter.im/LaravelRUS/laravel.ru
        'laravel.bot'   => '560281040fc9f982beb1908a',  // https://gitter.im/LaravelRUS/GitterBot

        'drupal'        => '565c8d6716b6c7089cbcbd5d', // https://gitter.im/DrupalRu/drupal.ru
        'druio'         => '568a54e816b6c7089cc11010', // https://gitter.im/dru-io/Drupal

        'yii.offtop'    => '55dc21c10fc9f982beae822c', // https://gitter.im/yiisoft/yii2/offtopic-rus
        'yii.chat'      => '555086c915522ed4b3e03631', // https://gitter.im/yiisoft/yii2/rus

        'phpua.symfony' => '5497ef29db8155e6700e1e81', // https://gitter.im/php-ua/symfony
        'phpua.php'     => '549565c0db8155e6700e16c1', // https://gitter.im/php-ua/php

        'vuejs.chat'    => '55d5eaab0fc9f982beae0db8', // https://gitter.im/vuejs-ru/Discussion
        
        'synrc.n2o'     => '54a2823adb8155e6700e3f37', // https://gitter.im/synrc/n2o
    ],


    // Middlewares
    'middlewares' => [
        // Вывод кармы по запросу
        //Domains\Bot\Middlewares\KarmaRenderMiddleware::class,

        // SQL билдер
        //Domains\Bot\Middlewares\SqlBuilderMiddleware::class,

        // Google поисковик
        Domains\Bot\Middlewares\GoogleSearchMiddleware::class,

        // Советник по оформлению сообщений
        //Domains\Bot\Middlewares\MarkdownAdviserMiddleware::class,

        // Слишком длинные сообщения
        //Domains\Bot\Middlewares\LongMessageMiddleware::class,

        // Подсчёт "спасибок"
        //Domains\Bot\Middlewares\KarmaCounterMiddleware::class,

        // Анализ ссылок на изображения и видео
        // App\Middlewares\InlineDataMiddleware::class => Storage::PRIORITY_MINIMAL,

        // Ответы на персональные вопросы для бота
        //Domains\Bot\Middlewares\PersonalAnswersMiddleware::class,
    ],


    // Subscribers
    'subscribers' => [
        // Подписывается на создание ачивки и отправляет сообщеньку в чат
        Domains\Bot\AchieveSubscriber::class,
    ],
];
