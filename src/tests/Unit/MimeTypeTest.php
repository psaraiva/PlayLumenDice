<?php

use App\Helpers\MimeType;

beforeEach(function () {
    $this->mimeTypeJson = MimeType::LIST[MimeType::TYPE_JSON];
    $this->mimeTypePng = MimeType::LIST[MimeType::TYPE_PNG];
    $this->mimeTypeSvg = MimeType::LIST[MimeType::TYPE_SVG];
    $this->mimeTypeMp4 = 'audio/mp4';
});

test('Get by type: Json', function () {
    $resp = MimeType::getByType(MimeType::TYPE_JSON);
    $this->assertEquals($this->mimeTypeJson, $resp);
})->group('helper', 'helper-mime-type');

test('Get by type: PNG', function () {
    $resp = MimeType::getByType(MimeType::TYPE_PNG);
    $this->assertEquals('image/png', $resp);
})->group('helper', 'helper-mime-type');

test('Get by type: SVG', function () {
    $resp = MimeType::getByType(MimeType::TYPE_SVG);
    $this->assertEquals('image/svg+xml', $resp);
})->group('helper', 'helper-mime-type');

test('Invalid argument to get by type', function () {
    MimeType::getByType('mp4');
})->throws(InvalidArgumentException::class)
  ->group('helper', 'helper-mime-type');

test('Get type suported', function () {
    $resp = MimeType::getTypeSuported($this->mimeTypeJson, MimeType::LIST);
    $this->assertEquals(MimeType::TYPE_JSON, $resp);
})->group('helper', 'helper-mime-type');

test('Invalid argument get type suported', function () {
    MimeType::getTypeSuported($this->mimeTypeMp4, MimeType::LIST);
})->throws(InvalidArgumentException::class)
  ->group('helper', 'helper-mime-type');

test('Mime type is suported', function () {
    $resp = MimeType::isSuported($this->mimeTypeJson, MimeType::LIST);
    $this->assertTrue($resp);
})->group('helper', 'helper-mime-type');

test('Mime type is not suported', function () {
    $resp = MimeType::isSuported('', MimeType::LIST);
    $this->assertFalse($resp);
})->group('helper', 'helper-mime-type');

test('it\'s Json', function () {
    $this->assertTrue(MimeType::isJson($this->mimeTypeJson));
})->group('helper', 'helper-mime-type');

test('it\'s not Json', function () {
    $this->assertFalse(MimeType::isJson($this->mimeTypeMp4));
})->group('helper', 'helper-mime-type');

test('it\'s PNG', function () {
    $this->assertTrue(MimeType::isPng($this->mimeTypePng));
})->group('helper', 'helper-mime-type');

test('it\'s not PNG', function () {
    $this->assertFalse(MimeType::isPng($this->mimeTypeMp4));
})->group('helper', 'helper-mime-type');

test('it\'s SVG', function () {
    $this->assertTrue(MimeType::isSvg($this->mimeTypeSvg));
})->group('helper', 'helper-mime-type');

test('it\'s not SVG', function () {
    $this->assertFalse(MimeType::isSvg($this->mimeTypeMp4));
})->group('helper', 'helper-mime-type');
