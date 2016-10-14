<?php
App::uses('DisciplinesTeam', 'Model');

/**
 * DisciplinesTeam Test Case
 */
class DisciplinesTeamTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.disciplines_team',
		'app.team',
		'app.discipline',
		'app.course'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DisciplinesTeam = ClassRegistry::init('DisciplinesTeam');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DisciplinesTeam);

		parent::tearDown();
	}

}
