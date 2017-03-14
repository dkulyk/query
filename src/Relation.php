<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query;

use DtKt\Query\Contracts\QueryEntity;
use DtKt\Query\Filters;

/**
 * Class Relation
 *
 * @package DtKt\Query
 */
class Relation extends Field
{
    /**
     * Relation constructor.
     *
     * @param string $field
     * @param string $label
     */
    public function __construct($field, $label)
    {
        parent::__construct($field, $label);
        $this->addFilters(new Filters\Relation());
    }

    /**
     * @return QueryEntity
     */
    public function getRelatedEntity(): QueryEntity
    {
        return Query::getMeta($this->entity->getModel()->{$this->field}()->getRelated());
    }
}
