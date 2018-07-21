<?php
/**
 * This file is part of m2code-gen <https://github.com/roma-glushko/m2code-gen>
 *
 * @author Roman Glushko <https://github.com/roma-glushko>
 */

namespace Atwix\System;

/**
 * Class VarRegistry
 */
class VarRegistry
{
    /**
     * @var array
     */
    protected $varRegistry = [];

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->varRegistry);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function get(string $name): string
    {
        if ($this->has($name)) {
            return $this->varRegistry[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return void
     */
    public function set(string $name, string $value)
    {
        $this->varRegistry[$name] = $value;
    }
}