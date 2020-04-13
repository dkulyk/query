<?php

declare(strict_types=1);

namespace DKulyk\Eloquent\Query;

use RuntimeException;
use DKulyk\Eloquent\Query\Contracts;
use DKulyk\Eloquent\Query\Types;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Query
 *
 * @package DtKt\Query
 */
class Query
{
    /**
     * @var Contracts\QueryEntity
     */
    protected $meta;
    /**
     * @var array|null
     */
    protected $fields;
    protected $limit = 0;
    protected $offset = 0;

    /**
     * @var array
     */
    protected $conditions;

    /**
     * Query constructor.
     *
     * @param  mixed  $model
     * @param  array  $conditions
     * @param  array|null  $fields
     *
     * @throws RuntimeException
     */
    public function __construct($model, array $conditions = [], array $fields = null)
    {
        $this->meta = self::getMeta($model);
        $this->fields = $fields;
        $this->conditions = $conditions;
    }

    /**
     * @param  mixed  $object
     *
     * @return Contracts\QueryEntity
     *
     * @throws RuntimeException
     */
    public static function getMeta($object): Contracts\QueryEntity
    {
        if ($object instanceof Contracts\QueryEntityAware) {
            return $object->getQueryEntity();
        }
        if ($object instanceof Contracts\QueryEntity) {
            return $object;
        }
        $class = get_class($object);

        throw new RuntimeException("Object {$class} not have meta.");
    }

    /**
     * @param  Contracts\QueryEntity  $meta
     * @param  Builder  $query
     * @param  array  $condition
     * @param  string  $boolean
     *
     * @return void
     *
     * @throws RuntimeException
     */
    protected function buildCondition(
        Contracts\QueryEntity $meta,
        Builder $query,
        array $condition,
        $boolean = 'and'
    ) {
        $fields = $meta->getFields();
        $field = $fields[$condition['field'] ?? null] ?? null;

        if ($field instanceof Contracts\QueryField) {
            $query->withoutGlobalScopes($field->getWithoutScopes());
        }

        if (array_key_exists('data', $condition) && array_key_exists('relation', $condition['data'])) {
            $type = $fields[$condition['data']['relation']]->getType();
            if ($type instanceof Types\Relation) {
                $meta = $type->getEntity();
            } else {
                throw new RuntimeException("Field {$condition['data']['relation']} is not instance of Types\Relation");
            }
            $method = $boolean === 'or' ? 'orWhereHas' : 'whereHas';
            $query->{$method}($condition['data']['relation'], function (Builder $query) use ($meta, $condition) {
                $query->where(function (Builder $builder) use ($meta, $condition, $query) {
                    $this->getSubQuery($meta, $builder, $condition['rules'], $condition['condition']);
                    $query->withoutGlobalScopes($builder->removedScopes());
                });
            }, ($condition['not'] ?? false ? '<' : '>='), $condition['data']['count'] ?? 1);
        } elseif (array_key_exists('condition', $condition)) {
            $query->where(function (Builder $builder) use ($query, $meta, $condition) {
                $this->getSubQuery($meta, $builder, $condition['rules'], $condition['condition']);
                $query->withoutGlobalScopes($builder->removedScopes());
            }, null, null, $boolean);
        } elseif ($field instanceof Contracts\QueryField) {
            $this->applyFilter(
                $query,
                $field,
                $condition['operator'],
                $condition['value'] ?? null,
                $boolean
            );
        } else {
            throw new RuntimeException("Field {$condition['field']} not found.");
        }
    }

    /**
     * @param  Builder  $query
     * @param  string  $filter
     * @param  Contracts\QueryField  $field
     * @param  mixed  $value
     * @param  string  $boolean
     *
     * @return Builder
     */
    protected function applyFilter(
        Builder $query,
        Contracts\QueryField $field,
        string $filter,
        $value,
        $boolean = 'and'
    ): Builder {
        $type = $field->getType();
        if ($type && $value !== null) {
            $value = is_array($value) ? array_map([$type, 'prepareValue'], $value) : $type->prepareValue($value);
        }
        $qualifiedField = $field->getQualifiedField();
        switch ($filter) {
            case 'equal':
                $query->where($qualifiedField, '=', $value, $boolean);
                break;
            case 'not_equal':
                $query->where($qualifiedField, '<>', $value, $boolean);
                break;
            case 'in':
                $query->whereIn($qualifiedField, (array) $value, $boolean);
                break;
            case 'not_in':
                $query->whereNotIn($qualifiedField, (array) $value, $boolean);
                break;
            case 'less':
                $query->where($qualifiedField, '<', $value, $boolean);
                break;
            case 'less_or_equal':
                $query->where($qualifiedField, '<=', $value, $boolean);
                break;
            case 'greater':
                $query->where($qualifiedField, '>', $value, $boolean);
                break;
            case 'greater_or_equal':
                $query->where($qualifiedField, '>=', $value, $boolean);
                break;
            case 'between':
                $query->whereBetween($qualifiedField, (array) $value, $boolean);
                break;
            case 'not_between':
                $query->whereNotBetween($qualifiedField, (array) $value, $boolean);
                break;
            case 'begins_with':
                $query->where($qualifiedField, 'like', "{$value}%", $boolean);
                break;
            case 'not_begins_with':
                $query->where($qualifiedField, 'not like', "{$value}%", $boolean);
                break;
            case 'contains':
                $query->where($qualifiedField, 'like', "%{$value}%", $boolean);
                break;
            case 'not_contains':
                $query->where($qualifiedField, 'not like', "%{$value}%", $boolean);
                break;
            case 'ends_with':
                $query->where($qualifiedField, 'like', "%{$value}", $boolean);
                break;
            case 'not_ends_with':
                $query->where($qualifiedField, 'not like', "%{$value}", $boolean);
                break;
            case 'is_empty':
                $query->where($qualifiedField, '=', '', $boolean);
                break;
            case 'is_not_empty':
                $query->where($qualifiedField, '<>', '', $boolean);
                break;
            case 'is_null':
                $query->whereNull($qualifiedField, $boolean);
                break;
            case 'is_not_null':
                $query->whereNotNull($qualifiedField, $boolean);
                break;
        }

        //dd($query->toSql(), $query->getBindings());
        return $query;
    }

    /**
     * @param  Contracts\QueryEntity  $meta
     * @param  Builder|null  $query
     * @param  array  $conditions
     * @param  string  $boolean
     *
     * @return Builder
     *
     * @throws RuntimeException
     */
    protected function getSubQuery(
        Contracts\QueryEntity $meta,
        Builder $query = null,
        array $conditions = [],
        $boolean = 'and'
    ): Builder {
        $model = $meta->getModel();
        $query = $query ?? $model->newQuery();

        foreach ($conditions as $condition) {
            $this->buildCondition($meta, $query, $condition, strtolower($boolean));
        }

        return $query;
    }

    /**
     * @param  Builder|null  $query
     *
     * @return Builder
     *
     * @throws RuntimeException
     */
    public function buildQuery(Builder $query = null): Builder
    {
        $query = $this->getSubQuery($this->meta, $query, $this->conditions['rules'], $this->conditions['condition']);

        if ($this->offset > 0) {
            $query->offset($this->offset);
        }
        if ($this->limit > 0) {
            $query->limit($this->limit);
        }

        return $query;
    }
}
