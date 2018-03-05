<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use Carbon\Carbon;

/**
 * Class PeriodSub
 * @package DKulyk\Eloquent\Query\Types
 */
class PeriodSub extends AbstractType
{
    /**
     * @var string
     */
    protected $type = 'after';

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException
     */
    public function prepareValue($value)
    {
        return Carbon::now()->sub(new \DateInterval($value))->toDateString();
    }

    /**
     * Get filter options.
     *
     * @return array
     */
    public function getFilter(): array
    {
        return [];
    }
}
