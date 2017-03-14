<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Filters;

/**
 * Class Greater
 *
 * @package DtKt\Query\Filters
 */
class Greater extends Operator
{
    protected $operator = '>';
    protected $not = '<=';
}
