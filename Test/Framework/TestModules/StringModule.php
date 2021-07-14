<?php


namespace Test\Framework\TestModules;


class StringModule
{
    public function __construct(\Framework\ManagerRouter $manager)
    {
        $manager->get('/demo',function(){

            return "DEMO";

        },'demo');
    }
}