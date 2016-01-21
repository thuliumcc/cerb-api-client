<?php
namespace Cerb\Model;

use Ouzo\Utilities\Arrays;
use stdClass;

abstract class BaseModel
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return Arrays::getValue($this->attributes, $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    /**
     * @param stdClass $result
     * @return static[]
     */
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

    /**
     * @param stdClass $result
     * @return static
     */
    public static function convertToModel($result)
    {
        return new static((array)$result);
    }
}
