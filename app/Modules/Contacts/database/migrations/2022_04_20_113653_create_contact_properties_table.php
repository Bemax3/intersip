<?php

use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Models\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Property::class)->constrained()->onDelete('cascade');
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_properties');
    }
};
