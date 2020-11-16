<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 先填充用户假数据
        $this->call(UsersTableSeeder::class);
        // 然后再填充话题数据，因为话题数据中需要填入用户数据
        $this->call(TopicsTableSeeder::class);
        // 填充回复数据，要在 user topic 数据生成之后
		$this->call(RepliesTableSeeder::class);
    }
}
