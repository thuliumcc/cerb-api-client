<?php
namespace Cerb\Model;

use Cerb\Result;
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
     * @return Result
     */
    public static function convertToResultModels($result)
    {
        $models = [];
        $total = 0;
        if ($result->results) {
            $total = $result->total;
            foreach ($result->results as $result) {
                $models[] = self::convertToModel($result);
            }
        }
        return new Result($models, $total);
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
