<?php

use App\Blog\BlogModule;
use function DI\{autowire, create, get};

return [


   'blog.prefix' => '/blog',
    BlogModule::class=>autowire(BlogModule::class)
    ->constructorParameter('prefix',get('blog.prefix'))

];