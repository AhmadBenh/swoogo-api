<?php

namespace App\Services;

use App\Services\SwoogoApiClientService;
use App\Repositories\StatsRepository;

class SwoogoStatsService
{

    protected $apiClient;
    protected $statsRepository;

    public function __construct(SwoogoApiClientService $apiClient, StatsRepository $statsRepository)
    {
        $this->apiClient = $apiClient;
        $this->statsRepository = $statsRepository;
    }

    public function processSwoogoStats(int $eventId, string $key, string $secret): array {
        $data = $this->apiClient->getApiSwoogoSessions($eventId, $key, $secret);
        
        if($data["response"] === 0) {
            return $data["payload"];
        }

        $stats = $this->getStats($data["payload"]["items"]);

        $stats = array_merge(["eventId" => $eventId], $stats);

        $this->storeStats($stats);

        return $stats;
    }

    private function getStats(array $sessions): array {

        $titleWords = [];
        $descriptionWords = [];

        $avg = 0;
        $avgCounter = 0;

        foreach($sessions ?? [] as $key => $value) {
            $id = $value["id"];
            $sessionDetails[$id] = $this->apiClient->getSwoogoSessionDetails($id);

            if($sessionDetails[$id]["response"] != 0) {
                $sessionDetails = $sessionDetails[$id]["payload"];
                // Classify title words by count
                if (isset($sessionDetails['name'])) {
                    $nameWords = explode(' ', $sessionDetails['name']);
                    foreach ($nameWords as $word) {
                        $word = strtolower(trim($word, '.,!?'));
                        if ($word !== '') {
                            $titleWords[$word] = ($titleWords[$word] ?? 0) + 1;
                            ++$avg;
                        }
                    }
                    ++$avgCounter;
                }

                // Classify description words by count
                if (isset($sessionDetails['description'])) {
                    $descriptionWordsExploded = explode(' ', $sessionDetails['description']);
                    foreach ($descriptionWordsExploded as $word) {
                        $word = strtolower(trim($word, '.,!?'));
                        if ($word !== '') {
                            $descriptionWords[$word] = ($descriptionWords[$word] ?? 0) + 1;
                        }
                    }
                }
            }
        }

        // Sort the words by frequency in descending order
        arsort($titleWords);
        arsort($descriptionWords);

        $stats = [
            "avgSessionTitleLength" => (int) ceil($avg/$avgCounter),
            "topTenSessionTitleWords" => array_slice($titleWords, 0, 10),
            "topTenSessionDescriptionWords" => array_slice($descriptionWords, 0, 10)
        ];

        // Return the top 10 most frequently used words
        return $stats;
    }

    private function storeStats($stats): void {
        $arrayToInsert = [
            "event_id" => $stats['eventId'],
            "created_at" => gmdate('Y-m-d H:i:s'),
            "stats" => $stats
        ];

        $this->statsRepository->create($arrayToInsert);
    }

    public function getAggregateStats(int $eventId) {
        $allStats = $this->statsRepository->getAllStats($eventId);

        return $allStats;
    }
}
