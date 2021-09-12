<?php

use App\Helpers\MimeType;

$serviceUrl = '/api/dice/play';
beforeEach(function () use ($serviceUrl) {
    $this->serviceUrl = $serviceUrl;
    $this->mimeTypeJson = MimeType::getByType(MimeType::TYPE_JSON);
});

test('Request play without parameters, by resource Json', function () {
    $this->get($this->serviceUrl, ['accept' => $this->mimeTypeJson])
        ->seeStatusCode(200)
        ->seeHeader('Content-Type', $this->mimeTypeJson)
        ->seeJsonStructure(['dice']);

    $data = (array) json_decode($this->response->getContent());
    $this->assertIsArray($data['dice']);
    $this->assertEquals(1, count($data['dice']));
    $this->assertGreaterThanOrEqual(1, $data['dice'][0]);
    $this->assertLessThanOrEqual(6, $data['dice'][0]);
})->group('resource-json', 'request');

test('Request Play Invalid Quantity Param, by resource Json', function () {
    $this->get($this->serviceUrl.'?quantity=120', ['accept' => $this->mimeTypeJson])
        ->seeStatusCode(422)
        ->seeHeader('Content-Type', $this->mimeTypeJson)
        ->seeJsonStructure(['quantity']);
})->group('resource-json', 'request');

test('Request Play Invalid Face Param, by resource Json', function () {
    $this->get($this->serviceUrl.'?face=50', ['accept' => $this->mimeTypeJson])
        ->seeStatusCode(422)
        ->seeHeader('Content-Type', $this->mimeTypeJson)
        ->seeJsonStructure(['face']);
})->group('resource-json', 'request');

test('RequestJsonPlayInvalidMultipleParam, by resource Json', function () {
    $this->get($this->serviceUrl.'?quantity=100&face=30', ['accept' => $this->mimeTypeJson])
        ->seeStatusCode(422)
        ->seeHeader('Content-Type', $this->mimeTypeJson)
        ->seeJsonStructure([
            'quantity',
            'face',
        ]);
})->group('resource-json', 'request');
