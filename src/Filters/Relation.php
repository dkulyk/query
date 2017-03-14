<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Contracts\QueryFilter;
use DKulyk\Eloquent\Query\Query;
use RuntimeException;
use Illuminate\Database\Eloquent;

/**
 * Class Relation
 *
 * @package DtKt\Query\Filters
 */
class Relation implements QueryFilter
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return '#';
    }

    /**
     * @inheritdoc
     */
    public function filter(Eloquent\Builder $query, string $field, $value, bool $not = false)
    {
        /* @var Eloquent\Relations\Relation $relation */
        $relation = $query->getModel()->{$field}();
        if ($relation instanceof Eloquent\Relations\Relation) {
            $query->whereHas($field, function (Eloquent\Builder $query) use ($relation, $value) {
                return (new Query($relation->getRelated(), $value))->buildQuery($query);
            }, $not ? '=' : '>=', $not ? 0 : 1);
        } else {
            throw new RuntimeException("Relation {$field} not resolved");
        }
    }
}
