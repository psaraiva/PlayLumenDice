<?php

use App\Models\Dice;

beforeEach(function () {
    $this->responseFail = ['dice'=>[]];
});

test('Value default to quantity', function () {
    $dice = new Dice();

    foreach(range(1,5) as $quantity) {
        $dice->quantity = $quantity;
        $this->assertTrue($dice->isValidQuantity());
    }
})->group('model', 'model-dice');

test('Limit to quantity', function () {
    $dice = new Dice();

    foreach(range(1, config('dice.quantity.limit')) as $quantity) {
        $dice->quantity = $quantity;
        $this->assertTrue($dice->isValidQuantity());
    }
})->group('model', 'model-dice');

test('Invalid value default to quantity', function () {
    $dice = new Dice();
    $invalids = [-1,6];

    foreach($invalids as $quantity) {
        $dice->quantity = $quantity;
        $this->assertFalse($dice->isValidQuantity());
    }
})->group('model', 'model-dice');

test('Valid value default to face', function () {
    $dice = new Dice();
    $expected = config('dice.face.allowed');

    foreach ($expected as $face) {
        $dice->face = $face;
        $this->assertTrue($dice->isValidFace());
    }
})->group('model', 'model-dice');

test('Invalid value to face', function () {
    $dice = new Dice();
    $expected = [-1,0,1,2,3,5,7,9,11,21];

    foreach ($expected as $face) {
        $dice->face = $face;
        $this->assertFalse($dice->isValidFace());
    }
})->group('model', 'model-dice');

test('Quantity dice by result', function () {
    $dice = new Dice();
    $quantity = rand(1,5);
    $dice->quantity = $quantity;
    $this->assertEquals($quantity, count($dice->play()['dice']));
})->group('model', 'model-dice');

test('Invalid value quantity to play', function () {
    $dice = new Dice();
    $dice->quantity = rand(-10, -1);
    $this->assertEquals($this->responseFail, $dice->play());    
})->group('model', 'model-dice');

test('Valid result by one dice', function () {
    $expected = config('dice.face.allowed');
    $dice = new Dice();

    foreach ($expected as $face) {
        $range = range(1, $face);
        $dice->face = $face;
        $this->assertTrue(in_array($dice->play()['dice'][0], $range));
    }
})->group('model', 'model-dice');

test('Valid result by mutiple dice', function () {
    $dice = new Dice(rand(1, 5));
    $resp = $dice->play();
    $this->assertEquals($dice->quantity, count($resp['dice']));
    foreach($resp['dice'] as $resp) {
        $this->assertTrue(in_array($resp, range(1, config('dice.face.default'))));
    }
})->group('model', 'model-dice');
