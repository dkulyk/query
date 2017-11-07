<?php
declare(strict_types=1);
namespace DKulyk\Eloquent\Query;

use DKulyk\Eloquent\Query\Contracts\QueryEntity;
use DKulyk\Eloquent\Query\Contracts\QueryField;
use DKulyk\Eloquent\Query\Contracts\QueryType;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Entity
 *
 * @package DtKt\Query
 */
abstract class Entity implements QueryEntity
{
    /**
     * @var Model|null
     */
    protected $model;

    /**
     * @var QueryField[]
     */
    protected $fields = [];

    /**
     * @var string
     */
    protected $name;

    protected $init = false;

    /**
     * Client constructor.
     *
     * @param Model|null  $model
     * @param string|null $name
     */
    public function __construct(Model $model, string $name = null)
    {
        $this->model = $model;
        $this->name = $name ?? $model->getTable();
    }

    abstract protected function init();

    private function boot()
    {
        if (!$this->init) {
            $this->init = true;
            $this->init();
        }
    }

    /**
     * @inheritdoc
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @inheritdoc
     */
    public function addFields(QueryField ...$fields): QueryEntity
    {
        $this->boot();
        foreach ($fields as $field) {
            $field->setEntity($this);
            $this->fields[$field->getField()] = $field;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFields(): array
    {
        $this->boot();
        return $this->fields;
    }

    /**
     * @inheritdoc
     */
    public function getField(string $field): QueryField
    {
        $this->boot();

        if (!array_key_exists($field, $this->fields)) {
            throw new \RuntimeException("Field with name {$field} does not exists");
        }

        return $this->fields[$field];
    }

    /**
     * @param string $name
     *
     * @return QueryEntity
     */
    public function setName(string $name): QueryEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        $filters = [];

        foreach ($this->getFields() as $field) {
            /* @var QueryType $type */
            $type = $field->getType();

            $filters[] = array_merge([
                'id' => $this->getName() . '.' . $field->getField(),
                'field' => $field->getField(),
                'label' => $field->getLabel(),
                'operators' => $field->getFilters()
            ], $type ? $type->getFilter() : []);
        }

        return $filters;
    }
}
