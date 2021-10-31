<?php

namespace App\Console\Commands;

use App\Models\Group;
use Illuminate\Console\Command;

class GenerateGroupsSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:groupsSlug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate groups slug';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $groups = Group::all();
        foreach ($groups as $group) {
            $group->generateSlug();
            $group->save();
        }
        echo 'finished';
    }
}
