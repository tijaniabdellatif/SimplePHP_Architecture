<?php


namespace App\Framework;

use App\Framework\Validation\ValidationError;

/**
 * Validate inputs entry
 * Class Validator
 * @package App\Framework
 */
class Validator
{
    /**
     * @var array
     */
    private array $params;
    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * Validator constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * To test the requirement presence of a field
     * @param string ...$keys
     * @return $this
     */
    public function required(string ...$keys):self
    {


        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addErrors($key, 'required');
            }
        }
        return $this;
    }

    /**
     * verify if a field is empty
     * @param string ...$keys
     * @return $this
     */
    public function notEmpty(string ...$keys):self
    {

        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)  || empty($value)) {
                $this->addErrors($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * Test the pattern of a slug if is it correctly given
     * @param string $key
     * @return Validator
     */
    public function slug(string $key):self
    {

        $value = $this->getValue($key);

        $pattern =  '/^([a-z0-9]+-?)+$/';
        if (!is_null($value) && !preg_match($pattern, $value)) {
            $this->addErrors($key, 'slug');
        }
        return $this;
    }


    /**
     * verify the length of a field
     * @param string $key
     * @param int $min
     * @param int|null $max
     * @return $this
     */
    public function length(string $key, int $min, ?int $max = null):self
    {

        $value = $this->getValue($key);
        $length = mb_strlen($value);

        if (!is_null($min) &&
            !is_null($max) &&
            $length < $min || $length > $max
        ) {
            $this->addErrors($key, 'between', [$min,$max]);
            return $this;
        }

        if (!is_null($min) &&
            $length < $min
        ) {
            $this->addErrors($key, 'minLength', [$min]);
            return $this;
        }
        if (!is_null($min) &&
            $length > $max
        ) {
            $this->addErrors($key, 'maxLength', [$max]);
        }

        return $this;
    }

    /**
     * Verify the right format of a date
     * @param string $key
     * @param string $format
     * @return $this
     */
    public function dateTime(string $key, string $format = "Y-m-d H:i:s"): self
    {
        $value = $this->getValue($key);
        $date = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();
        if ($errors['error_count'] > 0 ||
            $errors['warning_count'] > 0 ||
            $date === false) {
            $this->addError($key, 'datetime', [$format]);
        }
        return $this;
    }

    /**
     * verify is the existence of an error
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }



    /**
     * Get user errors
     * @return string[]
     */
    public function getErrors():array
    {

        return $this->errors;
    }



    /**
     * Get the value of the parameter given
     * @param string $key
     * @return mixed|null
     */
    private function getValue(string $key)
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }

        return null;
    }

    /**
     * Add an error to the array of params
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    private function addErrors(string $key, string $rule, array $attributes = []):void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }
}
