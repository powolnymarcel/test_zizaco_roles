<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AjoutUuidPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE posts ADD uuid BINARY(16) NOT NULL AFTER id;');
        DB::statement('CREATE UNIQUE INDEX posts_uuid_unique ON posts (uuid);');
    }

    public function down()
    {
        DB::statement('DROP INDEX posts_uuid_unique ON posts;');
        DB::statement('ALTER TABLE posts DROP uuid;');
    }
}
