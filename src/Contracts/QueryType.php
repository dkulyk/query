<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Contracts;

/**
 * Interface QueryType
 *
 * @package DtKt\Query\Contracts
 */
interface QueryType
{
    /**
     * Prepare value to query.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function prepareValue($value);

    /**
     * Print value.
     *
     * @param $value
     *
     * @return string
     */
    public function printValue($value): string;

    /**
     * Get filter options.
     *
     * @return array
     */
    public function getFilter(): array;
}
