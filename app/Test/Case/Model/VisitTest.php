<?php
App::uses('Visit', 'Model');

/**
 * Visit Test Case
 */
class VisitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.visit',
		'app.user',
		'app.group',
		'app.refusal',
		'app.city',
		'app.state',
		'app.team',
		'app.discipline',
		'app.course',
		'app.disciplines_team'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Visit = ClassRegistry::init('Visit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Visit);

		parent::tearDown();
	}

}
