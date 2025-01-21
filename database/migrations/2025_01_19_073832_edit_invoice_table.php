<?php

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
        Schema::table('invoices', function (Blueprint $table) {
            $table->datetime('expire_date')->nullable();
            $table->float('tax')->nullable();
            $table->float('fee')->nullable();
            $table->integer('sales_person_id')->nullable();
            $table->float('sales_commission')->nullable();
            $table->bigInteger('netto')->nullable();
            $table->string('inv_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'expire_date',
                'tax',
                'fee',
                'sales_person_id',
                'sales_commission',
                'netto',
                'inv_type',
            ]);
        });
    }
};
