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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropUnique('projects_slug_unique');
        });

        DB::statement('ALTER TABLE projects ADD UNIQUE INDEX projects_slug_unique (slug, deleted_at)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
