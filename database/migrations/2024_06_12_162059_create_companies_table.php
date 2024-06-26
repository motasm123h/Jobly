<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string("Date_of_Establishment");
            $table->unsignedInteger("employe_number");
            $table->string("Commercial_Record");
            $table->string("company_name");
            $table->string("contact_phone");
            $table->string("industry");
            $table->text("company_description");
            $table->string("company_website");
            $table->string("contact_email");
            $table->string("contact_person");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
