<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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

        $roleChoice = $this->choice('Role of user',['admin','editor'],1);

        if(!$role = Role::where('name',$roleChoice)->first()) {
             $this->error('Role not found');
            return -1;
        }

        $validator = Validator::make($user,[
            'email' => ['required','string','email','max:255',Rule::unique('users')],
            'password' => ['required',Password::defaults()]
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return -1;
        }

        DB::beginTransaction();
        try{
            $user = User::create([...$user]);
            $user->roles()->attach($role);
            DB::commit();
            $this->info($user['email'] . ' created successfully');
            return 0;
        }
        catch(\Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }
    }
}
