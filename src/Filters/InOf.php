<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Concerns\CanFilterValues;
use DKulyk\Eloquent\Query\Contracts\QueryFilterValues;

/**
 * Class InOf
 *
 * @package DtKt\Query\Filters
 */
class InOf extends In implements QueryFilterValues
{
    use CanFilterValues;
}
