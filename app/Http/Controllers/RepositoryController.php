<?php

namespace App\Http\Controllers;

use App\Jobs\SyncGithubRepositories;
use App\Models\Branch;
use App\Models\Commit;
use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class RepositoryController extends Controller
{
    public function index()
    {
        $repositories = Repository::paginate(env('PER_PAGE', 10));

        return response()->json([
            'repositories' => $repositories,
            'page_links' => $repositories->toArray()['links']
        ]);
    }

    public function show($id)
    {
        $repository = Repository::with(['branches.commits'])->findOrFail($id);

        $healthStatus = $this->analyzeRepositoryHealth($repository);

        return response()->json([
            'repository' => $repository,
            'healthStatus' => $healthStatus
        ], Response::HTTP_OK);
    }

    /**
     * Initialize sync of github repo to the db
     *
     * @return void
     */
    public function sync()
    {
        SyncGithubRepositories::dispatch();

        return response()->json([
            'message' => 'Sync in progress...'
        ], Response::HTTP_OK);
    }

    /**
     * Private function to analyze project's health
     *
     * @param [type] $repository
     * @return void
     */
    private function analyzeRepositoryHealth($repository)
    {
        $totalCommits = 0;
        $branchCommits = [];
        foreach ($repository->branches as $branch) {
            $commitsCount = $branch->commits->count();
            $branchCommits[$branch->name] = $commitsCount;
            $totalCommits += $commitsCount;
        }

        return [
            'totalCommits' => $totalCommits,
            'branchCommits' => $branchCommits,
            'lastCommitDate' => $repository->branches->flatMap->commits->max('date'),
        ];
    }
}
