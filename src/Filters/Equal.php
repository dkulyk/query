<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Equal
 *
 * @package DtKt\Query\Filters
 */
class Equal implements QueryFilter
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return '=';
    }

    /**
     * @inheritdoc
     */
    public function filter(Builder $query, string $field, $value, bool $not = false)
    {
        if ($value === null) {
            if ($not) {
                $query->getQuery()->whereNotNull($field);
            } else {
                $query->getQuery()->whereNull($field);
            }
        } else {
            $query->getQuery()->where($field, $not ? '!=' : '=', $value);
        }
    }
}
