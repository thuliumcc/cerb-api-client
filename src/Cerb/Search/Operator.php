<?php
namespace Cerb\Search;

class Operator
{
    const EQ = '=';
    const EQ_OR_NULL = 'equals or null';
    const NEQ = '!=';
    const IS_NULL = 'is null';
    const IS_NOT_NULL = 'is not null';
    const IN = 'in';
    const IN_OR_NULL = 'in or null';
    const NIN = 'not in';
    const NIN_OR_NULL = 'not in or null';
    const FULLTEXT = 'fulltext';
    const LIKE = 'like';
    const NOT_LIKE = 'not like';
    const GT = '>';
    const LT = '<';
    const GTE = '>=';
    const LTE = '<=';
    const BETWEEN = 'between';
    const NOT_BETWEEN = 'not between';
    const TRUE = '1';
    const CUSTOM = 'custom';
}
