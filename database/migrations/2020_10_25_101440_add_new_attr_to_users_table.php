<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAttrToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('telephone')->nullable();
            $table->string('band')->nullable();
            $table->string('genre')->nullable();
            $table->string('location')->nullable();
            $table->string('photo')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('paypal')->nullable();
            $table->string('venmo')->nullable();
            $table->string('cashapp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('zip');
            $table->dropColumn('telephone');
            $table->dropColumn('band');
            $table->dropColumn('genre');
            $table->dropColumn('location');
            $table->dropColumn('photo');
            $table->dropColumn('website');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('paypal');
            $table->dropColumn('venmo');
            $table->dropColumn('cashapp');
        });
    }
}
