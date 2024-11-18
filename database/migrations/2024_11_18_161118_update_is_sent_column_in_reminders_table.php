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
        Schema::table('reminders', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE reminders
            ALTER COLUMN is_sent DROP DEFAULT,
            ALTER COLUMN is_sent TYPE SMALLINT USING (CASE WHEN is_sent THEN 1 ELSE 0 END),
            ALTER COLUMN is_sent SET DEFAULT 0
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reminders', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE reminders
            ALTER COLUMN is_sent DROP DEFAULT,
            ALTER COLUMN is_sent TYPE BOOLEAN USING (CASE WHEN is_sent = 1 THEN TRUE ELSE FALSE END),
            ALTER COLUMN is_sent SET DEFAULT FALSE
        ");
        });
    }
};
