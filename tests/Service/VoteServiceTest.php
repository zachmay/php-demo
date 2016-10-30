<?php

namespace Demo\Tests\Service;

use Mockery;
use PHPUnit\Framework\TestCase;
use Aura\Sql\ExtendedPdo;
use Demo\Service\VoteService;

class VoteServiceTest extends TestCase
{
    public function setUp()
    {
        $this->db = Mockery::mock(ExtendedPdo::class);

        $this->voteService = new VoteService($this->db);
    }

    public function testFetchCandidatesWorks()
    {
        $this->assertEquals(['Hillary Clinton', 'Donald Trump'], $this->voteService->fetchCandidates());
    }

    public function testCastVoteWorks()
    {
        $username = 'John Q. Public';
        $candidate = 'Hillary Clinton';

        $this->db
            ->shouldReceive('perform')
            ->with(Mockery::any(), ['username' => $username, 'candidate' => $candidate])
            ->once()
            ->andReturn(true);

        $this->voteService->castVote($username, $candidate);
    }

    public function testAggregateResultsWorks()
    {
        $results = [
            [ 'name' => 'Hillary Clinton', 'count' => 5 ],
            [ 'name' => 'Donald Trump', 'count' => 3 ]
        ];

        $this->db
            ->shouldReceive('fetchAll')
            ->with(Mockery::any())
            ->once()
            ->andReturn($results);

        $expected = [
            'Hillary Clinton' => 5,
            'Donald Trump' => 3
        ];

        $this->assertEquals($expected, $this->voteService->aggregateResults());
    }

    public function testAggregateResultsMissingCandidateWorks()
    {
        $this->db
            ->shouldReceive('fetchAll')
            ->with(Mockery::any())
            ->once()
            ->andReturn([]);

        $expected = [
            'Hillary Clinton' => 0,
            'Donald Trump' => 0
        ];

        $this->assertEquals($expected, $this->voteService->aggregateResults());
    }

    public function tearDown()
    {
        Mockery::close();
    }
}

