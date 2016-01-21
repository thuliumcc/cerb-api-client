<?php
namespace Cerb;

use Exception;
use stdClass;

class ErrorHandler
{
    /**
     * @param stdClass $result
     * @throws Exception
     */
    public static function handle($result)
    {
        if ($result->__status == 'error') {
            throw new Exception($result->message);
        }
    }
}
