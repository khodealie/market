<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Validation\Rule;

class addNewAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:add-admin {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $id = $this->argument('id');
        $validation = validator(['id' => $id], ['id' => ['required', Rule::exists('users')]]);
        if ($validation->fails()) die;
        $user = User::find($id);
        $user->role()->associate(Role::where('name', \App\Enums\RoleName::ADMIN)->first());
        $user->save();
    }
}
