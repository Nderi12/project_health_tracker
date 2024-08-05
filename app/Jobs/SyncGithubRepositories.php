<?php

namespace App\Jobs;

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
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        $token = config('services.github.token');

        $response = Http::withToken($token)
            ->get('https://api.github.com/user/repos');

        if ($response->successful()) {
            $repositories = $response->json();
            foreach ($repositories as $repo) {
                $repository = Repository::updateOrCreate(
                    ['url' => $repo['html_url']],
                    ['name' => $repo['name'], 'description' => $repo['description']]
                );

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
    }
}
