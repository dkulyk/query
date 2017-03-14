<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Filters;

/**
 * Class Less
 *
 * @package DtKt\Query\Filters
 */
class Less extends Operator
{
    protected $operator = '<';
    protected $not = '>=';
}
