<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("CREATE OR REPLACE VIEW view_data_users AS 
            SELECT 
            u.*,

            us.first_name,
            us.last_name,
            us.address,
            us.phone_number,
            concat(us.first_name, ' ', us.last_name ) AS user_full_name

            ur.role_id

            FROM users AS u
            LEFT JOIN user_details AS us ON us.user_id = u.id
            LEFT JOIN user_roles AS ur ON ur.user_id = u.id

            ORDER BY u.id DESC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
