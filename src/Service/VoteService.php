<?php

namespace Demo\Service;

use PDO;

class VoteService
{
    protected $voteRepository;
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function fetchCandidates()
    {
        // In a more robust implementation, we'd query a candidates table for this list.
        // This way, at least, we don't hardcode the list in multiple places.
        return ['Hillary Clinton', 'Donald Trump'];
    }

    public function castVote($username, $candidate)
    {
        $this->db
            ->prepare('INSERT INTO voters VALUES (null, :username, :candidate, null)')
            ->execute([
                ':username' => $username,
                ':candidate' => $candidate
            ]);
    }

    public function aggregateResults()
    {
        return $this->db
            ->prepare('SELECT candidate as name, count(*) as count FROM voters GROUP BY candidate ORDER BY count(*) DESC')
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}
