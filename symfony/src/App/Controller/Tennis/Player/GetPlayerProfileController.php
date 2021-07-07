<?php

declare(strict_types=1);

namespace App\Controller\Tennis\Player;

use Domain\Tennis\SportRadarClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GetPlayerProfileController extends AbstractController
{
    public function __construct(
        private SportRadarClient $sportRadarClient
    ) {
    }

    #[Route(
        '/tennis/player-profile/{playerId}',
        name: 'tennis_get_player_profile',
        requirements: ['playerId' => '\d+'],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(int $playerId): JsonResponse
    {
        return $this->json($this->sportRadarClient->getPlayerProfile($playerId));
    }
}
