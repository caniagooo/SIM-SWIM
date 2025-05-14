<?php
// filepath: c:\Users\JITU\swim\database\migrations\2025_05_14_000006_create_sysparams_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysparamsTable extends Migration
{
    public function up()
    {
        Schema::create('sysparams', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sysparams');
    }
}