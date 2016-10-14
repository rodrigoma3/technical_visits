<?php
App::uses('Refusal', 'Model');

/**
 * Refusal Test Case
 */
class RefusalTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.refusal',
		'app.user',
		'app.visit'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Refusal = ClassRegistry::init('Refusal');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Refusal);

		parent::tearDown();
	}

}
