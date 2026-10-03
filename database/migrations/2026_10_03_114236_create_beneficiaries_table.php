<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('national_id', 10);
            $table->string('name');
            $table->string('phone');
            $table->date('dob');
            $table->timestamps();
            
            $table->unique(['tenant_id', 'national_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
