<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;

class SetupRolePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:role-permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add role & permissions base on config/setup.php';


    private function getPermissionIdsForRole($rolePermissionKeys): array
    {
        $result = [];
        foreach ($rolePermissionKeys as $rolePermissionKey) {
            $permission = Permission::firstOrCreate(['name' => config('setup.PERMISSIONS.' . $rolePermissionKey)]);
            $result[] = $permission->id;
        }
        return $result;
    }

    public function handle(): void
    {
        foreach (config('setup.PERMISSIONS') as $permission) {
            Permission::firstOrcreate(['name' => $permission]);
        }
        foreach (config('setup.ROLES') as $roleData) {
            $newRole = Role::firstOrCreate(['name' => $roleData['NAME']]);
            $newRole->permissions()->sync(($this->getPermissionIdsForRole($roleData['PERMISSIONS'])));
        }
    }
}
