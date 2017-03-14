<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Concerns\CanFilterValues;
use DKulyk\Eloquent\Query\Contracts\QueryFilterValues;

/**
 * Class EqualOf
 *
 * @package DtKt\Query\Filters
 */
class EqualOf extends Equal implements QueryFilterValues
{
    use CanFilterValues;
}

