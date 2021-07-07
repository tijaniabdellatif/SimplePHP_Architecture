<?php

namespace Test\Framework\TestModules;

class ErroredModule
{
  public function __construct(\Framework\ManagerRouter $manager)
  {
           $manager->get('/demo',function(){

               return new \stdClass();

           },'demo');
  }
}