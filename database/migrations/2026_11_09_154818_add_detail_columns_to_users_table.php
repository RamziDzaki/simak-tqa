<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'guru'])->default('guru')->after('password');
            $table->string('nip_nik')->nullable();
            $table->string('mata_pelajaran')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('status')->default('Aktif');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'role', 'nip_nik', 'mata_pelajaran', 'jenis_kelamin', 'status']);
        });
    }
};