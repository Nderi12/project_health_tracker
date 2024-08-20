<?php

namespace App\Jobs;

use App\Models\Organization;
use App\Models\Repository;
use App\Models\Branch;
use App\Models\Commit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SyncGithubRepositories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $token = config('services.github.token');

        // Fetch the authenticated user's repositories
        $this->syncRepositories('https://api.github.com/user/repos', $token);

        // Fetch the organizations the user is part of
        $organizationsResponse = Http::withToken($token)
            ->get('https://api.github.com/user/orgs');

        if ($organizationsResponse->successful()) {
            $organizations = $organizationsResponse->json();

            foreach ($organizations as $org) {
                // Store the organization in the database
                $organization = Organization::updateOrCreate(
                    ['github_id' => $org['id']],
                    ['name' => $org['login'], 'description' => $org['description']]
                );

                // Sync the repositories for each organization
                $this->syncRepositories("https://api.github.com/orgs/{$org['login']}/repos", $token, $organization->id);
            }
        }
    }

    /**
     * Sync repositories for a given URL (user or organization) and optional organization ID.
     *
     * @param string $url
     * @param string $token
     * @param int|null $organizationId
     */
    private function syncRepositories(string $url, string $token, int $organizationId = null)
    {
        $response = Http::withToken($token)->get($url);

        if ($response->successful()) {
            $repositories = $response->json();

            foreach ($repositories as $repo) {
                $repository = Repository::updateOrCreate(
                    ['url' => $repo['html_url']],
                    [
                        'name' => $repo['name'],
                        'description' => $repo['description'],
                        'organization_id' => $organizationId // Associate the repo with the organization
                    ]
                );

                $this->syncBranchesAndCommits($repo, $repository, $token);
            }
        }
    }

    /**
     * Sync branches and commits for a given repository.
     *
     * @param array $repo
     * @param Repository $repository
     * @param string $token
     */
    private function syncBranchesAndCommits(array $repo, Repository $repository, string $token)
    {
        $branchesResponse = Http::withToken($token)
            ->get(str_replace('{/branch}', '', $repo['branches_url']));

        if ($branchesResponse->successful()) {
            $branches = $branchesResponse->json();

            foreach ($branches as $branch) {
                $branchModel = Branch::updateOrCreate(
                    ['repository_id' => $repository->id, 'name' => $branch['name']],
                    []
                );

                $commitsResponse = Http::withToken($token)
                    ->get($repo['url'] . '/commits', ['sha' => $branch['name']]);

                if ($commitsResponse->successful()) {
                    $commits = $commitsResponse->json();

                    foreach ($commits as $commit) {
                        Commit::updateOrCreate(
                            ['branch_id' => $branchModel->id, 'sha' => $commit['sha']],
                            [
                                'message' => $commit['commit']['message'],
                                'date' => $commit['commit']['committer']['date']
                            ]
                        );
                    }
                }
            }
        }
    }
}
