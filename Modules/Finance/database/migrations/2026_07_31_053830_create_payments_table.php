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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Which invoice this payment applies to.
            // cascade delete: if an invoice is hard-deleted, its payments go too.
            // (Invoice uses SoftDeletes, so this only matters for permanent cleanup.)
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();

            // How much was paid in this single payment.
            $table->decimal('amount', 10, 2);

            // When the payment was actually received (may differ from created_at
            // if payments are logged after the fact).
            $table->date('paid_at');

            // No soft deletes — payments are treated as an immutable ledger.
            // Corrections should happen via a new adjustment/refund record later,
            // not by editing or deleting history.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};