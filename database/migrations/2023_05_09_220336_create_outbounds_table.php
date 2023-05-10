<?php

use App\Models\Project;
use App\Outbound\OutboundEnum;
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
        Schema::create('outbounds', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default(OutboundEnum::ChatUi->value);
            $table->boolean('active')->default(1);
            $table->foreignIdFor(Project::class);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outbounds');
    }
};
