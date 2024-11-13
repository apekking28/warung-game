<?php

use App\Traits\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use BaseModel;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publisher_id')->constrained('publishers')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->integer('stock')->nullable();
            $table->date('release_date');
            $table->string('image');
            $this->base($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
