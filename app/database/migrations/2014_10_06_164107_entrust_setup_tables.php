<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Creates the roles table
        Schema::create('roles', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Creates the assigned_roles (Many-to-Many relation) table
        Schema::create('assigned_roles', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles');
        });

        // Creates the permissions table
        Schema::create('permissions', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->timestamps();
        });

        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('permission_role', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions'); // assumes a users table
            $table->foreign('role_id')->references('id')->on('roles');
        });

        $this->setupFoundorAndBaseRolsPermission();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('assigned_roles', function (Blueprint $table) {
            $table->dropForeign('assigned_roles_user_id_foreign');
            $table->dropForeign('assigned_roles_role_id_foreign');
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign('permission_role_permission_id_foreign');
            $table->dropForeign('permission_role_role_id_foreign');
        });

        Schema::drop('assigned_roles');
        Schema::drop('permission_role');
        Schema::drop('roles');
        Schema::drop('permissions');
    }

    public function setupFoundorAndBaseRolsPermission()
    {
        // Create Roles
        $founder = new Role;
        $founder->name = 'Super';
        $founder->save();

        $founder = new Role;
        $founder->name = 'Standard';
        $founder->save();

        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();

        // Create User
        $user = new User;
        $user->username = 'hectorn ';
        $user->display_name = 'Standard';
        $user->email = 'hctr.441@gmail.com';
        $user->password = 'FUCKn0k14c300';
        $user->password_confirmation = 'FUCKn0k14c300';
        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = true;

        if(! $user->save()) {
            Log::info('Unable to create user '.$user->email, (array)$user->errors());
        } else {
            Log::info('Created user "'.$user->real_name.'" <'.$user->email.'>');
        }

        // Attach Roles to user
        $user->roles()->attach( $founder->id );

        // Create Permissions
        $manageContent = new Permission;
        $manageContent->name = 'manage_contents';
        $manageContent->display_name = 'Manage Content';
        $manageContent->save();

        $manageUsers = new Permission;
        $manageUsers->name = 'manage_users';
        $manageUsers->display_name = 'Manage Users';
        $manageUsers->save();

        // Assign Permission to Role
        $founder->perms()->sync([$manageContent->id,$manageUsers->id]);
        $admin->perms()->sync([$manageContent->id]);
    }

}
