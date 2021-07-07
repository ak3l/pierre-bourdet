<?php

declare(strict_types=1);

namespace App\Controller\Tennis\Rankings;

use Domain\Tennis\Repository\RankingsRepository;
use Model\Enum\CompetitionNameEnum;
use Model\Tennis\Exception\RankingNotFoundException;
use Model\Tennis\Rankings\Ranking;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SinglesRankingsController extends AbstractController
{
    public const PATH = '/tennis/singles-rankings/{competitionName}';

    public function __construct(
        private RankingsRepository $rankingsRepository,
        private LoggerInterface $logger
    ) {
    }

    #[Route(
        SinglesRankingsController::PATH,
        name: 'tennis_get_singles_rankings',
        requirements: ['competitionName' => CompetitionNameEnum::ATP.'|'.CompetitionNameEnum::WTA],
        methods: [Request::METHOD_GET]
    )]
    public function __invoke(string $competitionName): JsonResponse
    {
        try {
            return $this->json(
                $this->rankingsRepository->getSinglesRankingsByName($competitionName),
                context: ['groups' => Ranking::READ]
            );
        } catch (RankingNotFoundException $exception) {
            $this->logger->error('Could not retrieve rankings', [
                'competitionName' => $competitionName,
                'message' => $exception->getMessage(),
            ]);

            throw $this->createNotFoundException();
        }
    }
}
