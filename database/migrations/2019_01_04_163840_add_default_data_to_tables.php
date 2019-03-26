<?php

use App\Models\User\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User\UserRole;
use Illuminate\Database\Migrations\Migration;
use App\Models\Department;
use App\Components\CommonConstants;
use App\User;

class AddDefaultDataToTables extends Migration
{
    private $tableNameUser = 'users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET foreign_key_checks=0");
        /** Add data in users table */
        User::truncate();

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('.xHfBg>M;>2!f#U'),
                'status' => 1
            ]
        ]);

        echo "Data in '{$this->tableNameUser}' table has been updated successfully.\n";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::truncate();

        DB::update("ALTER TABLE users AUTO_INCREMENT = 1;");

        echo "Data in '{$this->tableNameUser}' table has been removed successfully.\n";
    }
}
