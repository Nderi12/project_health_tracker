<?php

namespace App\Http\Controllers;

use App\Jobs\SyncGithubRepositories;
use App\Models\Branch;
use App\Models\Commit;
use App\Models\Organization;
use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

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
        // Try get the repository, branches and commits from redis
        $cachedRepository = Redis::get("repository:$id");

        if ($cachedRepository) {
            // Decode the cache data
            $repository = json_decode($cachedRepository);
        } else {
            // Fetch from the database if not cached
            $repository = Repository::findOrFail($id);

            // Cache the repository data
            Redis::set("repository:$id", $repository->toJson());
            Redis::expire("repository:$id", 3600); // Set cache expiration to 1 hour

        }

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
        $lastCommitDate = null;

        // Fetch branches data from redis cache
        $branchKeys = Redis::keys("repository:{$repository->id}:branch:*");

        foreach ($branchKeys as $branchKey) {
            dd($branchKey);
            $cachedBranch = Redis::get($branchKey);

            if ($cachedBranch) {
                $branchData = json_decode($cachedBranch, true);
                $branchName = $branchData['name'];
                $commits = $branchData['commits'] ?? [];

                $commitsCount = count($commits);
                $branchCommits[$branchName] = $commitsCount;
                $totalCommits += $commitsCount;

                // Determine the latest commit date across all branches
                foreach ($commits as $commit) {
                    $commitDate = $commit['date'];
                    if (!$lastCommitDate || $commitDate > $lastCommitDate) {
                        $lastCommitDate = $commitDate;
                    }
                }
            }
        }

        return [
            'totalCommits' => $totalCommits,
            'branchCommits' => $branchCommits,
            'lastCommitDate' => $lastCommitDate,
        ];
    }
}
