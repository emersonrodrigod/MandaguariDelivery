<?php

class UserTest extends PHPUnit_Framework_TestCase {

    private $userData;

    protected function assertPreConditions() {
        $this->assertTrue(
                class_exists($class = 'User'), 'Class not found: ' . $class
        );
    }

    protected function setUp() {
        $this->userData = array(
            'name' => 'Emerson Dário',
            'email' => 'emersonrodrigod@gmail.com',
            'password' => '123456',
            'role' => 'user'
        );
    }

    protected function tearDown() {
        $user = new User();
        $db = $user->getAdapter();
        $db->query("truncate table user");
    }

    public function testInsertUserWithValidDataShouldWork() {
        $instance = new User();
        $id = $instance->create($this->userData);

        $this->assertEquals(1, $id);

        $insertedUser = $instance->getById(intval($id));
        $this->assertEquals($this->userData['name'], $insertedUser->name);
        $this->assertEquals($this->userData['email'], $insertedUser->email);
        $this->assertEquals($this->userData['password'], $insertedUser->password);
        $this->assertEquals($this->userData['role'], $insertedUser->role);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetWithInvalidIdShouldThrowAnException() {
        $instance = new User();
        $retrievedUser = $instance->getById(10);
    }

}
