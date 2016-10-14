<?php
/**
 * Visit Fixture
 */
class VisitFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'departure' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'arrival' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'destination' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'number_of_students' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'daily' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => true),
		'transport' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cost_transport' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => true),
		'distance' => array('type' => 'float', 'null' => false, 'default' => null, 'unsigned' => true),
		'objective' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'comments' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'city_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'team_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'visits_user_id' => array('column' => 'user_id', 'unique' => 0),
			'visits_city_id' => array('column' => 'city_id', 'unique' => 0),
			'visits_class_id' => array('column' => 'team_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'departure' => '2016-10-14 15:29:36',
			'arrival' => '2016-10-14 15:29:36',
			'destination' => 'Lorem ipsum dolor sit amet',
			'number_of_students' => 1,
			'daily' => 1,
			'transport' => 'Lorem ipsum dolor sit amet',
			'cost_transport' => 1,
			'distance' => 1,
			'objective' => 'Lorem ipsum dolor sit amet',
			'comments' => 'Lorem ipsum dolor sit amet',
			'status' => 1,
			'user_id' => 1,
			'city_id' => 1,
			'team_id' => 1
		),
	);

}
