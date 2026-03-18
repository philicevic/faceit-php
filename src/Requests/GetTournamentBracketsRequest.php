<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\DTO\MatchScore;
use Philicevic\FaceitPhp\DTO\Tournament\Brackets;
use Philicevic\FaceitPhp\DTO\Tournament\BracketsMatch;
use Philicevic\FaceitPhp\DTO\Tournament\BracketsRound;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentBracketsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $tournamentId) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId.'/brackets';
    }

    public function createDtoFromResponse(Response $response): Brackets
    {
        $data = $response->json();

        $matches = array_map(function (array $match): BracketsMatch {
            $results = null;
            if (isset($match['results'])) {
                $results = new MatchResult(
                    winner: $match['results']['winner'],
                    score: new MatchScore(byFaction: $match['results']['score']),
                );
            }

            return new BracketsMatch(
                uuid: $match['match_id'],
                faceitUrl: (string) ($match['faceit_url'] ?? ''),
                round: (int) ($match['round'] ?? 0),
                position: (int) ($match['position'] ?? 0),
                state: (string) ($match['state'] ?? ''),
                results: $results,
            );
        }, $data['matches'] ?? []);

        $rounds = array_map(function (array $round): BracketsRound {
            return new BracketsRound(
                round: (int) ($round['round'] ?? 0),
                label: (string) ($round['label'] ?? ''),
                matchesCount: (int) ($round['matches'] ?? 0),
                bestOf: (int) ($round['best_of'] ?? 0),
                startTime: (int) ($round['start_time'] ?? 0),
                startsAsap: (bool) ($round['starts_asap'] ?? false),
                substitutionTime: (int) ($round['substitution_time'] ?? 0),
                substitutionsAllowed: (bool) ($round['substitutions_allowed'] ?? false),
            );
        }, $data['rounds'] ?? []);

        return new Brackets(
            game: (string) ($data['game'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            matches: $matches,
            rounds: $rounds,
        );
    }
}
