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
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('logo');
            $table->string('country');
            $this->base($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
