<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query;


use DKulyk\Eloquent\Query\Contracts;
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
     * @param object     $model
     * @param array      $conditions
     * @param array|null $fields
     */
    public function __construct($model, array $conditions = [], array $fields = null)
    {
        $this->meta = self::getMeta($model);
        $this->fields = $fields;
        $this->conditions = $conditions;
    }

    /**
     * @param object $object
     *
     * @return Contracts\QueryEntity
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
        throw new \RuntimeException("Object {$class} not have meta.");
    }

    /**
     * @param Builder                $query
     * @param Contracts\QueryField[] $fields
     * @param array                  $condition
     */
    protected function buildCondition(Builder $query, array $fields, array $condition)
    {
        if (in_array($condition[0], ['or', 'and'], true)) {
            if (count($condition[1]) < 2) {
                $this->getSubQuery($this->meta, $query, $condition[1]);
            } else {
                $query->where(function (Builder $query) use ($condition) {
                    $this->getSubQuery($this->meta, $query, $condition[1], $condition[0]);
                });
            }
        } elseif (array_key_exists($condition[1], $fields)) {
            $field = $fields[$condition[1]];
            $filters = $field->getFilters();

            if (!array_key_exists($condition[0], $filters)) {
                throw new \RuntimeException("Filter {$condition[0]} not found.");
            }
            $filter = $filters[$condition[0]];
            $filter->filter($query, $field->getField(), $condition[2], (bool)($condition[3] ?? false));
        } else {
            throw new \RuntimeException("Field {$condition[1]} not found.");
        }
    }

    /**
     * @param Contracts\QueryEntity $meta
     * @param Builder|null          $query
     * @param array                 $conditions
     * @param string                $boolean
     *
     * @return Builder
     */
    protected function getSubQuery(
        Contracts\QueryEntity $meta,
        Builder $query = null,
        array $conditions = [],
        $boolean = null
    ): Builder {
        $fields = $meta->getFields();
        $model = $meta->getModel();
        $query = $query ?? $model->newQuery();

        foreach ($conditions as $condition) {
            if ($boolean === null) {
                $this->buildCondition($query, $fields, $condition);
            } else {
                $query->where(function (Builder $query) use ($condition, $fields) {
                    $this->buildCondition($query, $fields, $condition);
                }, null, null, $boolean);
            }
        }
        return $query;
    }

    /**
     * @param Builder|null $query
     *
     * @return Builder
     */
    public function buildQuery(Builder $query = null): Builder
    {
        $query = $this->getSubQuery($this->meta, $query, $this->conditions);

        if ($this->offset > 0) {
            $query->offset($this->offset);
        }
        if ($this->limit > 0) {
            $query->limit($this->limit);
        }

        return $query;
    }
}
