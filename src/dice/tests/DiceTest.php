<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Dice;

class DiceTest extends TestCase
{
    public function testValidValieToQuantity()
    {
        foreach(range(1,5) as $quantity) {
            $this->assertTrue(Dice::isValidQuantity($quantity));
        }
    }

    public function testInvalidValueToQuantity()
    {
        $invalids = [-1,0,6,20];
        foreach($invalids as $quantity) {
            $this->assertFalse(Dice::isValidQuantity($quantity));
        }
    }

    public function testValidValueToFace()
    {
        $expected = Dice::FACES;
        foreach ($expected as $face) {
            $this->assertTrue(Dice::isValidFace($face));
        }
    }

    public function testInvalidValueToFace()
    {
        $expected = [-1,0,1,2,3,5,7,9,11,21];
        foreach ($expected as $face) {
            $this->assertFalse(Dice::isValidFace(1,$face));
        }
    }

    public function testQuantityDiceByResult()
    {
        $quantity = rand(1,5);
        $this->assertEquals($quantity, count(Dice::play($quantity)['dice']));
    }

    public function testInvalidInputToPlay()
    {
        $expected = ['dice'=>[]];
        $this->assertEquals($expected, Dice::play(rand(-10,0)));
    }

    public function testValidResultByOneDice()
    {
        $expected = Dice::FACES;
        foreach ($expected as $dice) {
            $range = range(1, $dice);
            $this->assertTrue(in_array(Dice::play(1,$dice)['dice'][0], $range));
        }
    }

    public function testValidResultByMutipleDice()
    {
        $quantity = rand(1,5);
        $resp = Dice::play($quantity);

        $this->assertEquals($quantity, count($resp['dice']));
        foreach($resp['dice'] as $dice) {
            $this->assertTrue(in_array($dice, range(1,Dice::FACE_DEFAULT)));
        }
    }
}
