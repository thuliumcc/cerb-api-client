<?php
namespace Cerb\Model;

use Ouzo\Utilities\Arrays;

abstract class BaseModel
{
    private $attributes;

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        return Arrays::getValue($this->attributes, $name);
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public static function convertToModels($result)
    {
        if ($result->results) {
            $models = [];
            foreach ($result->results as $result) {
                $models[] = self::convertToModel($result);
            }
            return $models;
        }
        return [];
    }

    public static function convertToModel($result)
    {
        return new static((array)$result);
    }
}
