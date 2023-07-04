<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user['email'] = $this->ask('Enter email');
        $user['password'] = $this->secret('password');

        $role = $this->choice('Role of user',['admin','editor'],1);

        User::create([
            'id' => uuid_create(),...$user
        ]);
    return 0;
    }
}
