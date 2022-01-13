<?php

namespace App\Console\Commands;

use App\Http\Traits\NotificationsTrait;
use App\Models\Group;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class insertUserGroupReminder extends Command {
    use NotificationsTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insert_user_group_reminders {id*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle() {
        if ($this->argument('id')[0] == 0) {
            $this->insertAllAvailableGroups();
        } elseif (count($this->argument('id')) === 1) {
            $group = Group::where('id', $this->argument('id'))->first();
            $this->addGroupReminder($group);
        } elseif(count($this->argument('id')) > 1) {
            $groups = Group::whereIn('id', $this->argument('id'))->get();
            foreach ($groups as $group) {
                $this->addGroupReminder($group);
            }
        }
        echo 'finished';
    }

    private function insertAllAvailableGroups() {
        $groups = $this->getAllGroupsThatNotStartedYet();
        foreach ($groups as $group) {
            $this->addGroupReminder($group);
        }
    }
    private function addGroupReminder(Group $group) {
        $users = $group->students()->get()->pluck('user_id')->toArray();
        $usersIdsUnique = array_unique($users);
        foreach ($usersIdsUnique as $userId) {
            $user = User::where('id', $userId)->first();
            $this->insertUserNotification($user, $group);

        }
    }

    private function getAllGroupsThatNotStartedYet() {
        return  Group::where('start_date', '>', Carbon::now())->where('paid', 1)->get();
    }


}
