<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Dice;

class PlayTest extends TestCase
{
    public function testRequestPlayDefaultParams()
    {
        $response = $this->call('GET', '/api/play');
        $this->assertEquals(200, $response->status());
        $response->assertJsonStructure(['dice']);
    }

    public function testRequestPlayInvalidQuantityParam()
    {
        $response = $this->call('GET', '/api/play?quantity=120');
        $response->assertStatus(422);
    }
}
