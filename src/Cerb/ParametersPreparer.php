<?php
namespace Cerb;

class ParametersPreparer
{
    public static function postfields($from)
    {
        $postfields = null;
        if (!is_null($from)) {
            if (is_array($from)) {
                $postfields = [];
                foreach ($from as $pair) {
                    if (is_array($pair) && 2 == count($pair)) {
                        $postfields[] = $pair[0] . '=' . rawurlencode($pair[1]);
                    }
                }
                $postfields = implode('&', $postfields);
            } elseif (is_string($from)) {
                $postfields = $from;
            }
        }
        return $postfields;
    }

    public static function sortedUrlQueryString($queryString)
    {
        $queryString = ltrim($queryString, '?');
        $args = [];
        $parts = explode('&', $queryString);
        foreach ($parts as $part) {
            $pair = explode('=', $part, 2);
            if (is_array($pair) && count($pair) == 2) {
                $args[$pair[0]] = $part;
            }
        }
        ksort($args);
        return implode("&", $args);
    }
}
