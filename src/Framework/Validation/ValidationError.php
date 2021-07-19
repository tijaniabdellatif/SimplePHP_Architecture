<?php


namespace App\Framework\Validation;

class ValidationError
{

    /**
     * @var string
     */
    private string $rule;
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string[]
     */
    private array $messages = [

        'required' => 'the field %s is required',
        'empty' => 'the field %s should not be empty',
        'slug' => 'the field %s is not a valid slug',
        'between' => 'the filed %s must be between %d and %d characters',
        'minLength' => 'the field %s must not be less than %d characters',
        'maxLength' => 'the field %s must not exceed %d characters',
        'datetime' => 'the field %s must be a valid date (%s)',
    ];
    /**
     * @var array
     */
    private array $attributes;

    /**
     * ValidationError constructor.
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    public function __construct(string $key, string $rule, array $attributes = [])
    {
         $this->key = $key;
         $this->rule = $rule;
         $this->attributes = $attributes;
    }

    /**
     * Convert an object to a string content
     * %s to target the type, sprintf() to represent the value as a string
     * @return string
     */
    public function __toString()
    {
        $params = array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }
}
