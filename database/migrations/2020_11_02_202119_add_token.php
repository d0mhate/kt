<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::beginTransaction();
            Schema::table('users', function ($table) {
                $table->string('api_token', 80)->after('password')
                    ->unique()
                    ->nullable()
                    ->default(null);
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users','api_token')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('api_token');
            });
        }
    }
}
