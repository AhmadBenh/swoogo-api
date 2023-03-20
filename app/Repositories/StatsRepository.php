<?php

namespace App\Repositories;

use App\Models\SessionStats;

class StatsRepository extends BaseRepository
{

    public function __construct(SessionStats $sessionStats) {
        parent::__construct($sessionStats);
    }

    public function createStats(array $data)
    {
        return SessionStats::create($data);
    }

    public function updateStats(int $id, array$data)
    {
        $dbData = SessionStats::findOrFail($id);
        $dbData->update($data);
        return $dbData;
    }

    public function deleteStats(int $id)
    {
        $dbData = SessionStats::find($id);
        $dbData->delete();
        return true;
    }

    public function findStats(int $id)
    {
        return SessionStats::findOrFail($id);
    }

    public function getAllStats()
    {
        return SessionStats::all();
    }
}
