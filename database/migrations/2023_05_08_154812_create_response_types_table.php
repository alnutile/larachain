<?php

use App\Models\Project;
use App\ResponseType\ResponseTypeEnum;
use App\ResponseType\TransformerTypeEnum;
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
        Schema::create('response_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Project::class);
            $table->integer('order')->default(1);
            $table->string('type')->default(ResponseTypeEnum::ChatUi->value);
            $table->longText('prompt_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response_types');
    }
};
