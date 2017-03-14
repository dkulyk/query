<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface QueryEntity
 *
 * @package DtKt\Contracts
 */
interface QueryEntity
{
    /**
     * @return QueryField[]
     */
    public function getFields(): array;

    /**
     * @param QueryField[] ...$fields
     *
     * @return QueryEntity
     */
    public function addFields(QueryField ...$fields): QueryEntity;

    /**
     * Get model.
     *
     * @return Model
     */
    public function getModel(): Model;
}
