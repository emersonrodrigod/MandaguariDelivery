<?php

class User extends Zend_Db_Table_Abstract {

    protected $_name = 'user';

    public function create(array $data) {
        $id = $this->insert($data);
        return $id;
    }

    public function getById($id) {
        $user = $this->find($id)->current();

        if ($user) {
            return $user;
        }

        throw new RuntimeException('Fail to retrieve the User with id: ' . $id);
    }

}
