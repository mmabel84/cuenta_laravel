<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Bican\Roles\Models\Role;
use Bican\Roles\Models\Permission;

class sed_roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
			'name' => 'Admin',
			'slug' => 'admin',
			'description' => '', // optional
			'level' => 1, // optional, set to 1 by default
		]);

		$createUsersPermission = Permission::create([
			'name' => 'Create users',
			'slug' => 'create.users',
			'description' => '', // optional
		]);

    }
}
