<?php

declare(strict_types=1);

namespace Domain\Tennis\Normalizer;

use Model\Tennis\Enum\SurfaceTypeEnum;
use Model\Tennis\PlayerProfile\Period;
use Model\Tennis\PlayerProfile\Surface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class PeriodNormalizer implements ContextAwareNormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer
    ) {
    }

    /** @param Period $period */
    public function normalize($period, string $format = null, array $context = []): array
    {
        $filteredSurfaces = [];

        foreach ($period->surfaces as $surface) {
            if ($this->isNewSurface($filteredSurfaces, $surfaceType = SurfaceTypeEnum::resolveType($surface->type))) {
                $surface->type = $surfaceType;
                $filteredSurfaces[$surfaceType] = $surface;

                continue;
            }

            $this->addSurfaceStatistics($filteredSurfaces, $surface, $surfaceType);
        }

        $period->surfaces = array_values($filteredSurfaces);

        /** @var array $data */
        $data = $this->normalizer->normalize($period, $format, $context);

        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Period;
    }

    /** @param array<string, Surface> $filteredSurfaces */
    private function isNewSurface(array $filteredSurfaces, string $surfaceType): bool
    {
        foreach ($filteredSurfaces as $surface) {
            if ($surfaceType === $surface->type) {
                return false;
            }
        }

        return true;
    }

    /** @param array<string, Surface> $filteredSurfaces */
    private function addSurfaceStatistics(array $filteredSurfaces, Surface $surface, string $surfaceType): void
    {
        $filteredSurfaces[$surfaceType]->statistics->competitionsPlayed += $surface->statistics->competitionsPlayed;
        $filteredSurfaces[$surfaceType]->statistics->competitionsWon += $surface->statistics->competitionsWon;
        $filteredSurfaces[$surfaceType]->statistics->matchesPlayed += $surface->statistics->matchesPlayed;
        $filteredSurfaces[$surfaceType]->statistics->matchesWon += $surface->statistics->matchesWon;
    }
}
