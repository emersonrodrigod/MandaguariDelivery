<?php

class CategoryTest extends PHPUnit_Framework_TestCase {

    private $categoryData;

    protected function setUp() {
        $this->categoryData = array(
            0 => array(
                'name' => 'Category root',
                'enable' => 1,
                'id_area' => 1
            ),
            1 => array(
                'name' => 'Children category',
                'enable' => 1,
                'id_parent' => 1,
                'id_area' => 1
            ),
            2 => array(
                'name' => 'Invalid Children',
                'enable' => 1,
                'id_parent' => 5,
                'id_area' => 1
            )
        );

        $area = new Area();
        $area->insert(array(
            'name' => 'Root Area'
        ));
    }

    public function testCreateWithValidDataShouldWork() {
        $instance = new Category();
        $id = $instance->create($this->categoryData[0]);

        $this->assertEquals(1, $id);
    }

    public function testShoulCreateChildrenRow() {
        $instance = new Category();
        $root = $instance->create($this->categoryData[0]);
        $id = $instance->create($this->categoryData[1]);
        $this->assertEquals(2, $id);

        $childrens = $instance->getChildrens(intval($root));
        $this->assertInstanceOf("Zend_Db_Table_Rowset", $childrens);
    }

    /**
     * @expectedException Zend_Db_Exception
     * 
     */
    public function testCreateChildrenWithInvalidParentShouldThrowAnException() {
        $instance = new Category();
        $instance->create($this->categoryData[0]);
        $instance->create($this->categoryData[2]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRetrieveWithInvalidIdShouldThrowAnException() {
        $instance = new Category();
        $instance->getById('');
    }

    /**
     * @expectedException RuntimeException
     */
    public function testRetrieveWithInvalidSourceShouldThrowAnException() {
        $instance = new Category();
        $instance->getById(1);
    }

    /**
     * @expectedException RuntimeException
     */
    public function testGetChildrensWithInvalidParentShouldThrowAnException() {
        $instance = new Category();
        $instance->getChildrens(5);
    }

    protected function tearDown() {
        $category = new Category();
        $db = $category->getAdapter();
        $db->query("truncate table category");
        $db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $db->query("truncate table area");
        $db->query("SET FOREIGN_KEY_CHECKS = 1;");
    }

}
