<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\Component\Data;

/**
 * Class ValidationResultData
 */
class ValidationResultData
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param string $message
     *
     * @return void
     */
    public function addError(string $message)
    {
        $this->errors[] = $message;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }
}