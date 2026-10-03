<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->string('gender', 10)->nullable()->after('name');
            $table->string('city')->nullable()->after('dob');
            $table->unsignedTinyInteger('family_members')->default(1)->after('city');
            $table->decimal('monthly_income', 10, 2)->nullable()->after('family_members');
            $table->string('category', 30)->nullable()->after('monthly_income');
            $table->string('status', 20)->default('active')->after('category');

            $table->index(['tenant_id', 'created_at']);
            $table->index(['tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropIndex(['tenant_id', 'created_at']);
            $table->dropIndex(['tenant_id', 'status']);
            $table->dropColumn(['gender', 'city', 'family_members', 'monthly_income', 'category', 'status']);
        });
    }
};
