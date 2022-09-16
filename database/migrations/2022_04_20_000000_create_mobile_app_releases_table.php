<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileAppReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_app_releases', function (Blueprint $table) {
            $table->id();
            $table->string('version', 20);
            $table->string('package', 20)->nullable();
            $table->integer('number')->nullable();
            $table->boolean('force')->default(false);
            $table->content();
            $table->resourceHits();
            $table->softDeletes();
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
        Schema::dropIfExists('mobile_app_releases');
    }
}
