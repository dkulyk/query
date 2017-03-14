<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Contracts;

/**
 * Interface QueryFilterValues
 *
 * @package DtKt\Query\Contracts
 */
interface QueryFilterValues
{
    /**
     * Get filter values.
     *
     * @return array
     */
    public function getValues(): array;

    /**
     * Set values.
     *
     * @param array|callable $values
     *
     * @return QueryFilter
     */
    public function setValues($values): QueryFilter;
}
