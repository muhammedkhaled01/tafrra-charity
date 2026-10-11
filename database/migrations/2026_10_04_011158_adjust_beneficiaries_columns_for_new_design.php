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
        Schema::table('beneficiaries', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('first_name')->after('national_id');
            $table->string('father_name')->nullable()->after('first_name');
            $table->string('grandfather_name')->nullable()->after('father_name');
            $table->string('family_name')->after('grandfather_name');
            $table->string('marital_status')->nullable()->after('phone');
            $table->string('neighborhood')->nullable()->after('city');
            $table->text('notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries', function (Blueprint $table) {
            //
        });
    }
};
