<?php

namespace Core;

/**
 * Defines a User taken from a database.
 */
class User {
    
    /** @var array Contains any data not explicitly defined. */
    private array $data = [];
  
    /**
     * Sets the relevant property.
     * 
     * @param string $key   The key to be set.
     * @param string $value The value of the property.
     * 
     * @return void
     */
    public function __set(string $key, string $value): void
    {
        // Keys are often taken from MySQL, and as such are formatted to
        // snake_case. We need to convert it to standardised pascalCase.
        $key = str_replace('_', ' ', $key);
        $key = ucwords($key);
        $key = str_replace(' ', '', $key);
        $key = lcfirst($key);
        $this->data[$key] = $value;
    }
  
    /**
     * Gets the relevant property.
     * 
     * @param string $key The key to be fetched.
     * 
     * @throws \Exception if key cannot be found.
     * 
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        if (array_key_exists($key, $this->data))
        {
            return $this->data[$key];
        }
  
        throw new \Exception("Invalid property {$key} in " . static::class);
    }
}