<?php

use yii\db\Migration;

/**
 * Class m191024_102020_push_active_user
 */
class m191024_102020_push_active_user extends Migration
{
    /**
     * @return bool
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'apple-admin',
            'auth_key' => '3f6ePpt1eGMWnh_1cvfBj8MbIAImEyL0',
            'password_hash' => '$2y$13$KyAm21wdToe3vNJbMJ41Xu7F8k1qJOaR0qWOEeR4OKpC8UmOr.B7G',
            'verification_token' => '0hjCAH2OpClrXqNROWPvSc8cNUCW5NY6_1571400983',
            'password_reset_token' => NULL,
            'created_at' => 1571400983,
            'updated_at' => 1571402559,
            'email' => 'apple-task@demo.com',
            'status' => 10,
        ]);
    }

    /**
     * @return bool
     */
    public function safeDown()
    {
        $this->delete('user', ['username' => 'apple-admin']);
    }
}
