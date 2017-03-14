<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Contracts\QueryFilter;
use DKulyk\Eloquent\Query\Contracts\QueryFilterMultiple;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class In
 *
 * @package DtKt\Query\Filters
 */
class In implements QueryFilter, QueryFilterMultiple
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'in';
    }

    /**
     * @inheritdoc
     */
    public function filter(Builder $query, string $field, $value, bool $not = false)
    {
        if ($not) {
            $query->getQuery()->whereNotIn($field, $value);
        } else {
            $query->getQuery()->whereIn($field, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return 0;
    }
}
