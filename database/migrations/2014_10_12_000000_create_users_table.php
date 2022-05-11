<?php

use App\Models\Country;
use App\Models\Role;
use App\Models\SettingsTimezone;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_first_name');
            $table->string('user_middle_name')->nullable();
            $table->string('user_last_name');
            $table->string('user_user_name');
            $table->string('user_mail')->unique();
            $table->string('user_number')->unique();
            $table->boolean('user_is_blocked')->default(false);
            $table->date('user_dob');
            $table->string('user_adress');
            $table->foreignIdFor(Role::class)->constrained();
            $table->foreignIdFor(SettingsTimezone::class)->constrained();
            $table->foreignIdFor(Country::class)->constrained();
            $table->timestamp('user_mail_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
