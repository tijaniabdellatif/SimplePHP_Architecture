<?php


namespace App\Framework;

use App\Framework\Validator\ValidationError;

class Validator
{
    /**
     * @var array
     */
    private array $params;

    /**
     * @var string[]
     */
    private array $errors = [];

    /**
     * Validator constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Verifying is a field is required
     * @param string ...$keys
     * @return $this
     */
    public function required(string ...$keys):self
    {

        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * verifying if a field is emppty
     * @param string ...$keys
     * @return $this
     */
    public function notEmpty(string ...$keys):self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) || empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * Verify that the field is a slug and accept a regex
     * example : [article-prod-1]
     * @param string $key
     * @return $this
     */
    public function slug(string $key):self
    {
        $value=$this->getValue($key);
        $pattern = '/^([a-z0-9]+-?)+$/';
        if (!is_null($value) && !preg_match($pattern, $value)) {
            $this->addError($key, 'slug');
        }
        return $this;
    }

    /**
     * Validating date and time
     * @param string $key
     * @param string $format
     * @return $this
     */
    public function dateTime(string $key, string $format = 'Y-m-d H:i:s'):self
    {
        $value = $this->getValue($key);
        $date = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();

        if ($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date === false) {
            $this->addError($key, 'datetime', [$format]);
        }

        return $this;
    }

    /**
     * Test the length of fields
     * @param string $key
     * @param int|null $min
     * @param int|null $max
     * @return $this
     */
    public function length(string $key, ?int $min, ?int $max = null):self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);

        if (!is_null($min) &&
            !is_null($max) &&
        $length < $min || $length > $max) {
            $this->addError($key, 'between', [$min,$max]);
            return $this;
        }

        if (!is_null($min) &&
            $length < $min) {
            $this->addError($key, 'minLength', [$min]);
            return $this;
        }
        if (!is_null($max) &&
            $length > $max) {
            $this->addError($key, 'maxLength', [$max]);
        }
        return $this;
    }


    /**
     * get all errors in array of string
     * @return ValidationError[]
     */
    public function getErrors():array
    {

        return $this->errors;
    }

    /**
     * Add an error to the errors array
     * @param string $key
     * @param string $rule
     * @param array|null $params
     * @return void
     */
    private function addError(string $key, string $rule, array $params = []):void
    {

        $this->errors[$key] = new ValidationError($key, $rule, $params);
    }

    /**
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
     * @return bool
     */
    public function isValid():bool
    {
        return empty($this->errors);
    }
}
