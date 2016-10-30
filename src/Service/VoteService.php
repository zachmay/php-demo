<?php

namespace Demo\Service;

use Aura\Sql\ExtendedPdo;

class VoteService
{
    protected $voteRepository;
    protected $db;

    public function __construct(ExtendedPdo $db)
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
        $this->db->perform('INSERT INTO voters VALUES (null, :username, :candidate, null)', [
            'username' => $username,
            'candidate' => $candidate
        ]);
    }

    public function aggregateResults()
    {
        $results = $this->db->fetchAll('SELECT candidate as name, count(*) as count FROM voters GROUP BY candidate ORDER BY count(*) DESC');

        // If a candidate has no votes, it won't appear in the above result set. Let's ensure that all
        // candidates are present, with zero vote count, if they're not already there. Additionally,
        // we will normalize this into a name => count map.
        $out = [];
        foreach ($results as $result) {
            $out[$result['name']] = $result['count'];
        }
        foreach ($this->fetchCandidates() as $candidate) {
            if (!array_key_exists($candidate, $out)) {
                $out[$candidate] = 0;
            }
        }

        return $out;
    }
}
