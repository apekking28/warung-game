<?php

use App\Traits\BaseModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use BaseModel;
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 12, 2);
            $table->string('status');
            $table->string('payment_status');
            $table->datetime('order_date');
            $this->base($table);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};