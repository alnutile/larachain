<?php

use App\Models\Project;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('token_count');
            $table->string("status")->default("pending"); //complete,running
            $table->string("type")->default("web_scrape"); //pdf_scrape
            $table->string("guid")->nullable();
            $table->foreignIdFor(Project::class);
            $table->json("meta_data")->nullable();
            $table->vector('embedding', 1536)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
