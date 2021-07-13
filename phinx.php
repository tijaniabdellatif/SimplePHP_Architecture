<?php

require 'public/index.php';

$migrations = [];
$seeds = [];

foreach($modules as $module){

    if($module::__MIGRATIONS__){

        $migrations[]= $module::__MIGRATIONS__;
    }

    if($module::__SEEDS__){

        $seeds[]= $module::__SEEDS__;
    }
}
return
[
    'paths' => [
        'migrations' => $migrations,
        'seeds' => $seeds
    ],
    'environments' => [
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $app->getContainer()->get('database.host'),
            'name' => $app->getContainer()->get('database.name'),
            'user' => $app->getContainer()->get('database.username'),
            'pass' => $app->getContainer()->get('database.password'),
            'port' => '3306',
            'charset' => 'utf8'
        ]
    ]

];
