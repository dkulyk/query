<?php
declare(strict_types = 1);

namespace DKulyk\Eloquent\Query;

use DKulyk\Eloquent\Query\Contracts\QueryEntity;
use DKulyk\Eloquent\Query\Contracts\QueryField;
use DKulyk\Eloquent\Query\Contracts\QueryFilter;
use DKulyk\Eloquent\Query\Contracts\QueryType;

/**
 * Class Field
 *
 * @package DtKt\Query
 */
class Field implements QueryField
{
    /**
     * @var string
     */
    protected $field;
    /**
     * @var string
     */
    protected $label;
    /**
     * @var QueryType|null
     */
    protected $type;
    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var QueryEntity
     */
    protected $entity;

    /**
     * Field constructor.
     *
     * @param string $field
     * @param string $label
     * @param QueryType|null $type
     * @param array $filters
     */
    public function __construct(string $field, string $label, QueryType $type = null, array $filters = [])
    {
        $this->field = $field;
        $this->label = $label;
        $this->type = $type;
        $this->setFilters($filters);
    }

    /**
     * @inheritdoc
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @inheritdoc
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public function setType(QueryType $type = null): QueryField
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFilters(array $filters): QueryField
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param QueryEntity $entity
     */
    public function setEntity(QueryEntity $entity)
    {
        $this->entity = $entity;
    }
}
