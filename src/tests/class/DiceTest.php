<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Dice;

class DiceTest extends TestCase
{
    public const RESPONSE_FAIL = ['dice'=>[]];

    public function testValueDefaultToQuantity()
    {
        $dice = new Dice();
        foreach(range(1,5) as $quantity) {
            $dice->quantity = $quantity;
            $this->assertTrue($dice->isValidQuantity());
        }
    }

    public function testLimitToQuantity()
    {
        $dice = new Dice();
        foreach(range(1, config('dice.quantity.limit')) as $quantity) {
            $dice->quantity = $quantity;
            $this->assertTrue($dice->isValidQuantity());
        }
    }

    public function testInvalidValueDefaultToQuantity()
    {
        $dice = new Dice();
        $invalids = [-1,6];
        foreach($invalids as $quantity) {
            $dice->quantity = $quantity;
            $this->assertFalse($dice->isValidQuantity());
        }
    }

    public function testValidValueDefaultToFace()
    {
        $dice = new Dice();
        $expected = config('dice.face.allowed');
        foreach ($expected as $face) {
            $dice->face = $face;
            $this->assertTrue($dice->isValidFace());
        }
    }

    public function testInvalidValueToFace()
    {
        $dice = new Dice();
        $expected = [-1,0,1,2,3,5,7,9,11,21];
        foreach ($expected as $face) {
            $dice->face = $face;
            $this->assertFalse($dice->isValidFace());
        }
    }

    public function testQuantityDiceByResult()
    {
        $dice = new Dice();
        $quantity = rand(1,5);
        $dice->quantity = $quantity;
        $this->assertEquals($quantity, count($dice->play()['dice']));
    }

    public function testInvalidValueQuantityToPlay()
    {
        $dice = new Dice();
        $dice->quantity = rand(-10, -1);
        $this->assertEquals(self::RESPONSE_FAIL, $dice->play());
    }

    public function testInvalidValueFaceToPlay()
    {
        $expected = ['dice'=>[]];
        $dice = new Dice();
        $dice->quantity = rand(-10, -1);
        $this->assertEquals(self::RESPONSE_FAIL, $dice->play());
    }

    public function testValidResultByOneDice()
    {
        $expected = config('dice.face.allowed');
        $dice = new Dice();

        foreach ($expected as $face) {
            $range = range(1, $face);
            $dice->face = $face;
            $this->assertTrue(in_array($dice->play()['dice'][0], $range));
        }
    }

    public function testValidResultByMutipleDice()
    {
        $dice = new Dice(rand(1, 5));
        $resp = $dice->play();
        $this->assertEquals($dice->quantity, count($resp['dice']));
        foreach($resp['dice'] as $resp) {
            $this->assertTrue(in_array($resp, range(1, config('dice.face.default'))));
        }
    }
}
