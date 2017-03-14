<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Contracts\QueryFilter;
use DKulyk\Eloquent\Query\Contracts\QueryFilterMultiple;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Between
 *
 * @package DtKt\Query\Filters
 */
class Between implements QueryFilter, QueryFilterMultiple
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'between';
    }

    /**
     * @inheritdoc
     */
    public function filter(Builder $query, string $field, $value, bool $not = false)
    {
        if ($not) {
            $query->getQuery()->whereNotBetween($field, $value);
        } else {
            $query->getQuery()->whereBetween($field, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return 2;
    }
}
