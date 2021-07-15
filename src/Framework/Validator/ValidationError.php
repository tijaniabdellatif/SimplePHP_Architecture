<?php


namespace App\Framework\Validator;

class ValidationError
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $rule;

    /**
     * @var string[]
     */
    private array $messages = [

        'required' => 'the field %s is required',
        'empty' => 'the field %s must not be empty',
        'slug' => 'the field %s is not a valid slug',
        'between' => 'the field %s must be between %d and %d characters',
        'minLength'=>'the field %s must contain %d characters',
        'maxLength'=>'the field %s must not be over than %d characters',
        'datetime' => 'the field %s must be a valid date (%s)'
    ];
    /**
     * @var array
     */
    private array $params;

    public function __construct(string $key, string $rule, array $params = [])
    {
        $this->key=$key;
        $this->rule =$rule;
        $this->params = $params;
    }

    public function __toString()
    {
        $params = array_merge([$this->messages[$this->rule], $this->key], $this->params);
        return (string) call_user_func_array(
            'sprintf',
            $params
        );
    }
}
