<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    private $tasks = 'tasks';

    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up()
    {
        try {
            DB::beginTransaction();
            if (!Schema::hasTable($this->tasks)) {
                Schema::create($this->tasks, function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('title')->nullable();
                    $table->string('body')->nullable();
                    $table->enum('status', ['finished', 'progress', 'terminated'])->nullable();
                    $table->bigInteger('user_id')->unsigned();
                    $table->index(['id', 'status', 'title', 'body', 'user_id']);
                    $table->timestamps();

                    $table->foreign('user_id')
                        ->references('id')
                        ->on('users')
                        ->onDelete('CASCADE');
                });
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
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
        try {
            DB::beginTransaction();
            Schema::dropIfExists($this->tasks);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
