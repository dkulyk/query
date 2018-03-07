<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use Carbon\Carbon;

/**
 * Class DateTime
 *
 * @package DtKt\Query\Types
 */
class DateTime extends Date
{
    protected $type = 'datetime';

    /**
     * DateTime constructor.
     *
     * @param string $format
     * @param string $printFormat
     * @param array $options
     */
    public function __construct($format = 'd.m.Y H:i', $printFormat = 'dd.mm.yyyy hh:ii', array $options = [])
    {
        parent::__construct($format, $printFormat, $options);
    }

    /**
     * @inheritdoc
     */
    public function prepareValue($value)
    {
        return $value === null ? null : Carbon::createFromFormat($this->format, $value)->toDateTimeString();
    }
}
