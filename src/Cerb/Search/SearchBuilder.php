<?php
namespace Cerb\Search;

class SearchBuilder
{
    /**
     * @var array
     */
    private $search = [];

    /**
     * @param string $value
     * @return $this
     */
    public function addQuick($value)
    {
        $this->search[] = ['q', $value];
        return $this;
    }

    /**
     * @param string $criteria
     * @param string $operator
     * @param string $value
     * @return $this
     */
    public function addCriteria($criteria, $operator, $value)
    {
        $this->search[] = ['criteria[]', $criteria];
        $this->search[] = ['oper[]', $operator];
        $this->search[] = ['value[]', $value];
        return $this;
    }

    /**
     * @param string $column
     * @return $this
     */
    public function addSortBy($column)
    {
        $this->search[] = ['sortBy', $column];
        return $this;
    }

    /**
     * @param int $type
     * @return $this
     */
    public function addSortAsc($type)
    {
        $this->search[] = ['sortAsc', $type];
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function addLimit($limit)
    {
        $this->search[] = ['limit', $limit];
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function addPage($page)
    {
        $this->search[] = ['page', $page];
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->search;
    }

    /**
     * @return SearchBuilder
     */
    public static function instance()
    {
        return new self();
    }
}
