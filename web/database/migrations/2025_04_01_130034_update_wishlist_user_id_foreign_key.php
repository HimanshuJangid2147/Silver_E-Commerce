<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWishlistUserIdForeignKey extends Migration
{
    public function up()
    {
        Schema::table('wishlist', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign('wishlist_user_id_foreign');

            // Add the new foreign key constraint referencing member_login_details
            $table->foreign('user_id')
                  ->references('id')
                  ->on('member_login_details')
                  ->onDelete('cascade')
                  ->name('wishlist_user_id_foreign');
        });
    }

    public function down()
    {
        Schema::table('wishlist', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign('wishlist_user_id_foreign');

            // Revert to the original foreign key constraint referencing users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->name('wishlist_user_id_foreign');
        });
    }
}
