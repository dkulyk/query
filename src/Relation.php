<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query;

use DKulyk\Eloquent\Query\Contracts\QueryType;
use DKulyk\Eloquent\Query\Types\Relation as RelationType;

/**
 * Class Relation
 *
 * @package DtKt\Query
 */
class Relation extends Field
{
    /**
     * @return QueryType|null
     */
    public function getType(): ?QueryType
    {
        return $this->type ?: new RelationType($this->entity->getModel()->{$this->field}()->getModel());
    }
}
