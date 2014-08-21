<?php

class Area extends Zend_Db_Table_Abstract {

    protected $_name = 'area';
    protected $_dependentTables = array('Category');

    public function create($data) {
        if (is_array($data)) {
            return $this->insert($data);
        }

        throw new InvalidArgumentException('Invalid data for insert area');
    }

    public function getById($id) {
        if (is_int($id)) {
            return $this->find($id)->current();
        }

        throw new InvalidArgumentException($id . ' is not valid');
    }

}
