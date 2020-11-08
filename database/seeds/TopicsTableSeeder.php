<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // 生成 100 条话题假数据
        factory(Topic::class)->times(100)->create();
    }

}

