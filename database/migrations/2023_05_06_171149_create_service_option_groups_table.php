<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOptionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_option_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('vendor_id')->nullable()->constrained();
            $table->boolean('multiple')->default(true);
            $table->boolean('required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('in_order')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_option_groups');
    }
}
