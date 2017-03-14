<?php
declare(strict_types = 1);
namespace DKulyk\Eloquent\Query\Concerns;

use DKulyk\Eloquent\Query\Contracts\QueryFilterValues;

/**
 * Class CanFilterValues
 *
 * @package DtKt\Query\Concerns
 * @mixin QueryFilterValues
 */
trait CanFilterValues
{
    /**
     * @var array|callable
     */
    protected $values;

    /**
     * @inheritdoc
     */
    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getValues(): array
    {
        if (is_callable($this->values)) {
            $this->values = call_user_func($this->values);
        }

        return $this->values;
    }
}
