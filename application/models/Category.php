<?php

class Category extends Zend_Db_Table_Abstract {

    protected $_name = 'category';
    protected $_dependentTables = array('Category');
    protected $_referenceMap = array(
        'Parent' => array(
            'refTableClass' => 'Category',
            'refColumns' => array('id'),
            'columns' => array('id_parent')
        ),
        'Area' => array(
            'refTableClass' => 'Area',
            'refColumns' => array('id'),
            'columns' => array('id_area')
        )
    );

    public function create(array $data) {
        return $this->insert($data);
    }

    public function getById($id) {
        if (is_int($id)) {
            $retrieved = $this->find($id)->current();

            if ($retrieved) {
                return $retrieved;
            }

            throw new RuntimeException('Fail to retrive Category with id: ' . $id);
        }

        throw new InvalidArgumentException('Value ' . $id . ' is a not valid Id');
    }

    public function getChildrens($id) {
        $parent = $this->getById($id);

        if (!empty($parent->toArray())) {
            return $parent->findDependentRowset('Category');
        }

        throw new RuntimeException('Fail to find parent');
    }

}
