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
        // لتجنب أخطاء إذا كان الحقل موجودًا بالفعل
        if (!Schema::hasColumn('companies', 'logo_path')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->string('logo_path')->nullable()->after('additional_documents');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('companies', 'logo_path')) {
            Schema::table('companies', function (Blueprint $table) {
                $table->dropColumn('logo_path');
            });
        }
    }
}; 