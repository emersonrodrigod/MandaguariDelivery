<?php

class AreaTest extends PHPUnit_Framework_TestCase {

    private $areaData;

    protected function setUp() {
        $this->areaData = array(
            'name' => 'Test área'
        );
    }

    public function testShouldCreateNewArea() {
        $instance = new Area();
        $id = $instance->create($this->areaData);

        $this->assertEquals(1, $id);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateWithInvalidDataShouldThrowAnException() {
        $instance = new Area();
        $instance->create(null);
    }

    public function testShouldRetrieveAnAreaWhenValidIdPassed() {
        $instance = new Area();
        $id = $instance->insert($this->areaData);

        $retrieved = $instance->getById(intval($id));
        $this->assertEquals($this->areaData['name'], $retrieved->name);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRetrieveWithInvalidIdShouldThrowAnException() {
        $instance = new Area();
        $instance->getById(null);
    }

    public function testeDeleteWhenNotContainsRelationshipShouldWork() {
        $instance = new Area();
        $created = $instance->create($this->areaData);

        $retrieve = $instance->getById(intval($created));
        $retrieve->delete();
    }
    

    protected function tearDown() {
        $instance = new Area();
        $db = $instance->getAdapter();
        $db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $db->query("truncate table area");
        $db->query("SET FOREIGN_KEY_CHECKS = 1;");
    }

}
