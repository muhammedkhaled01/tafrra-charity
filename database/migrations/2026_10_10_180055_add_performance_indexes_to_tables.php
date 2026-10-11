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
        try {
            Schema::table('beneficiaries', function (Blueprint $table) {
                $table->index('national_id');
                $table->index('status');
            });
        } catch (Exception $e) {
        }

        try {
            Schema::table('tenants', function (Blueprint $table) {
                $table->index('is_active');
            });
        } catch (Exception $e) {
        }

        try {
            Schema::table('payments', function (Blueprint $table) {
                $table->index(['status', 'paid_at']);
            });
        } catch (Exception $e) {
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::table('beneficiaries', function (Blueprint $table) {
                $table->dropIndex(['national_id']);
                $table->dropIndex(['status']);
            });
        } catch (Exception $e) {
        }

        try {
            Schema::table('tenants', function (Blueprint $table) {
                $table->dropIndex(['is_active']);
            });
        } catch (Exception $e) {
        }

        try {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropIndex(['status', 'paid_at']);
            });
        } catch (Exception $e) {
        }
    }
};
