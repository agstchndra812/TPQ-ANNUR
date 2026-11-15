<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing 'admin' role to 'guru'
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'guru']);

        // You can manually create a superadmin user using tinker or seeder
        // Example: php artisan tinker
        // User::create(['name' => 'Super Admin', 'email' => 'superadmin@tpq.com', 'password' => Hash::make('password'), 'role' => 'superadmin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert 'guru' role back to 'admin'
        DB::table('users')
            ->where('role', 'guru')
            ->update(['role' => 'admin']);

        // Change superadmin to admin
        DB::table('users')
            ->where('role', 'superadmin')
            ->update(['role' => 'admin']);
    }
};
