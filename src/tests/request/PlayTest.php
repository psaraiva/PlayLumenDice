<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\Dice;

class PlayTest extends TestCase
{
    public function testRequestPlayDefaultParams()
    {
        $this->call('GET', '/api/play')
            ->assertStatus(200)
            ->assertJsonStructure(['dice']);
    }

    public function testRequestPlayInvalidQuantityParam()
    {
        $this->call('GET', '/api/play?quantity=120')
            ->assertStatus(422)
            ->assertJsonStructure(['quantity']);
    }

    public function testRequestPlayInvalidFaceParam()
    {
        $this->call('GET', '/api/play?face=50')
            ->assertStatus(422)
            ->assertJsonStructure(['face']);
    }

    public function testRequestPlayInvalidMultipleParam()
    {
        $this->call('GET', '/api/play?quantity=100&face=30')
            ->assertStatus(422)
            ->assertJsonStructure([
                'quantity',
                'face',
            ]);
    }
}
