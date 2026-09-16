<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Migration_003_create_products_table
{
    /**
     * Run the migrations
     */
    public function up()
    {
        $forge = new \LavaLust\Schema\DBForge();
        
        $forge->create_table('products', function($table) {
            $table->increments('id')->primary();
            $table->string('product_name', 100);
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamp('created_at')->default('CURRENT_TIMESTAMP');
        });
    }

    /**
     * Revert the migrations
     */
    public function down()
    {
        $forge = new \LavaLust\Schema\DBForge();
        $forge->drop_table('products');
    }
}
