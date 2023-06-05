<?php

use App\Transformer\TransformerEnum;
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
        Schema::table('transformers', function (Blueprint $table) {
            $table->string('type')->default(TransformerEnum::PdfTransformer->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transformers', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
