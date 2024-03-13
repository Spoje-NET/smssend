<?php

use PHPUnit\Framework\TestCase;

class SmsTest extends TestCase
{
    public function testSetNumber()
    {
        $sms = new Sms();
        $sms->setNumber('+420 739 778 202');
        $this->assertEquals('420739778202', $sms->getNumber());
    }

    public function testSetMessage()
    {
        $sms = new Sms();
        $sms->setMessage('Hello, world!');
        $this->assertEquals('Hello, world!', $sms->getMessage());
    }

    public function testSendMessage()
    {
        // Mock the dependencies (e.g., HuaweiApi\Router) to isolate the test
        $routerMock = $this->createMock(\HSPDev\HuaweiApi\Router::class);
        $routerMock->expects($this->once())
            ->method('sendSms')
            ->with('420739778202', 'Hello, world!')
            ->willReturn(true);

        // Set up the Sms instance with the mocked dependencies
        $sms = new Sms();
        $sms->setNumber('+420 739 778 202');
        $sms->setMessage('Hello, world!');
        $sms->setRouter($routerMock);

        // Call the method under test
        $result = $sms->sendMessage();

        // Assert the result
        $this->assertTrue($result);
        $this->assertTrue($sms->isSent());
    }
}