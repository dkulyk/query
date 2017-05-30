<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query\Types;

use Carbon\Carbon;

/**
 * Class Date
 *
 * @package DtKt\Query\Types
 */
class Date extends AbstractType
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $printFormat;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $type = 'date';

    /**
     * Date constructor.
     *
     * @param string $format
     * @param string $printFormat
     * @param array $options
     */
    public function __construct($format = 'd.m.Y', $printFormat = 'dd.mm.yyyy', array $options = [])
    {
        $this->format = $format;
        $this->printFormat = $printFormat;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     *
     * @throws \InvalidArgumentException
     */
    public function prepareValue($value)
    {
        return Carbon::createFromFormat($this->format, $value)->toDateString();
    }

    /**
     * @inheritdoc
     */
    public function getFilter(): array
    {
        return [
            'type' => $this->type,
            'data' => [
                'format' => $this->printFormat,
                'options' => $this->options
            ]
        ];
    }
}
