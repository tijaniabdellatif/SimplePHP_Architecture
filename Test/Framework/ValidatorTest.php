<?php


namespace Test\Framework;

use App\Framework\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    private function makeValidator(array $params): Validator
    {
        return new Validator($params);
    }
    public function testRequired()
    {

        $error = $this->makeValidator(["name" =>"hello"]);
            
            $error->required('name', 'content');
            $error->getErrors();

        $this->assertCount(1, $error);
        $this->assertEquals("the field content is required", $error['content']);
    }

    public function testRequiredSuccess()
    {
        $error = $this->makeValidator([
            "name" =>"hello",
             "content" => "this is a content"
        ]);

        $error->required('name', 'content');
        $error->getErrors();

        $this->assertCount(0, $error);
    }

    public function testSlugSuccess()
    {
        $error = $this->makeValidator([

            'slug' => 'aze-aze-de1'
        ])  ->slug('slug')
            ->getErrors();

        $this->assertCount(0, $error);
    }


    public function testSlugError()
    {
        $error = $this->makeValidator([

        'slug' => 'aze-aze-de1',
        'slug2' => 'aze-aze-De1',
        'slug3' => 'aze--aze-de1'

        ])->required('slug4')
            ->slug('slug')
            ->slug('slug2')
            ->slug('slug3')
            ->slug('slug4')
            ->getErrors();

        $this->assertCount(3, $error);
    }
}
