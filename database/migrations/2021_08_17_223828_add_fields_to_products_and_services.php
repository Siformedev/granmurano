<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProductsAndServices extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products_and_services', function (Blueprint $table) {
            $table->integer('permite_renegociacao')->after('date_end')->default(0);
            $table->decimal('multa', 8, 2)->after('permite_renegociacao')->default(0);
            $table->decimal('juros_ao_mes', 8, 2)->after('multa')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
