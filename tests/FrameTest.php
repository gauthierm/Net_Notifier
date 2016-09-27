<?php

require_once 'Net/Notifier/WebSocket/Frame.php';

class Net_Notifier_FrameTest extends PHPUnit_Framework_TestCase
{
	public function testIsFinalDefault()
	{
		$frame = new Net_Notifier_WebSocket_Frame(
			'',
			Net_Notifier_WebSocket_Frame::TYPE_TEXT,
			false,
			false
		);

		$this->assertFalse(
			$frame->getFinal(),
			'Default frame constructor not set as final.'
		);
	}

	public function testConstructorFinalDefault()
	{
		$frame = new Net_Notifier_WebSocket_Frame(
			'',
			Net_Notifier_WebSocket_Frame::TYPE_TEXT,
			false
		);

		$this->assertTrue(
			$frame->getFinal(),
			'Default frame constructor not set as final.'
		);
	}
}

?>
