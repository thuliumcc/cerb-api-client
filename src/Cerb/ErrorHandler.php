<?php
namespace Cerb;

use Exception;

class ErrorHandler
{
    public static function handle($result)
    {
        if ($result->__status == 'error') {
            throw new Exception($result->message);
        }
    }
}
