<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add cta_banner to the enum
        DB::statement("ALTER TABLE promotions MODIFY COLUMN banner_position ENUM('top', 'sidebar', 'footer', 'home_banner', 'category_banner', 'cta_banner') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove cta_banner from the enum
        DB::statement("ALTER TABLE promotions MODIFY COLUMN banner_position ENUM('top', 'sidebar', 'footer', 'home_banner', 'category_banner') NULL");
    }
};
