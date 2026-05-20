<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('export_request_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['invoice', 'customs_declaration', 'manifest', 'packing_list', 'certificate_of_origin']);
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
