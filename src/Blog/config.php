<?php

use App\Blog\BlogModule;
use function DI\autowire;
use function DI\create;
use function DI\get;

return [


   'blog.prefix' => '/blog',
    BlogModule::class=>autowire(BlogModule::class)
    ->constructorParameter('prefix', get('blog.prefix'))

];
