<?php

use App\Models\Outbound;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('response_types', function (Blueprint $table) {
            $table->dropColumn('project_id');
            $table->foreignIdFor(Outbound::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('response_types', function (Blueprint $table) {
            //
        });
    }
};
