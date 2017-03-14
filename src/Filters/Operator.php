<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query\Filters;

use DKulyk\Eloquent\Query\Contracts\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Operator
 *
 * @package DtKt\Query\Filters
 */
abstract class Operator implements QueryFilter
{
    protected $operator;
    protected $not;

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->operator;
    }

    /**
     * @inheritdoc
     */
    public function filter(Builder $query, string $field, $value, bool $not = false)
    {
        $query->getQuery()->where($field, $not ? $this->not : $this->operator, $value);
    }
}
