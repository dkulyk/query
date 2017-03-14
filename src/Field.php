<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query;

use DtKt\Query\Contracts\QueryEntity;
use DtKt\Query\Contracts\QueryField;
use DtKt\Query\Contracts\QueryFilter;
use DtKt\Query\Contracts\QueryType;

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
     * @param string              $field
     * @param string              $label
     * @param QueryType|null $type
     */
    public function __construct(string $field, string $label, QueryType $type = null)
    {
        $this->field = $field;
        $this->label = $label;
        $this->type = $type;
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
    public function getType(): ?QueryType
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
    public function addFilters(QueryFilter ...$filters): QueryField
    {
        foreach ($filters as $filter) {
            $this->filters[$filter->getName()] = $filter;
        }

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
