<?php

namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;
use App\Card\Player;
use App\Card\CardHand;
use App\Controller\InitCardGameController;

/**
 * Test cases for the InitCardGameController class.
 */
class InitCardGameControllerTest extends TestCase
{
    /**
     * Test preparePlayerData() returns correct formatted data.
     */
    public function testPreparePlayerData(): void
    {
        $player = $this->createMock(Player::class);
        $hand = $this->createMock(CardHand::class);

        $player->method('getHand')->willReturn($hand);
        $hand->method('getCardsAsString')->willReturn('♠10 ♣K');
        $player->method('getPoints')->willReturn(20);
        $player->method('checkStatus')->willReturn('playing');

        $controller = new InitCardGameController();
        $result = $controller->preparePlayerData($player);

        $this->assertEquals([
            'cards' => '♠10 ♣K',
            'points' => 20,
            'status' => 'playing',
        ], $result);
    }
}
