<?php

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $tagsAll = App\Models\Tag::all()->toArray();

        $users = App\Models\User::all()->toArray();

        $number = env('NUMBER_OF_SAMPLE_BLOG_POSTS_TO_SEED');
        for($i = 0; $i < $number; $i++) {

            $userId = $users[random_int(0, count($users) - 1)]['id'];
            $title = $faker->sentence;

            $post = new Post;

            $post->title = $title;
            $post->featured_img = $faker->imageUrl(900, 600);
            $post->publish_date = $faker->date('Y-m-d');
            $post->content = $faker->paragraph(6);
            $post->is_important = $faker->boolean;
            $post->user_id = $userId;

            $post->save();

            $postId = $post->id;

            $tags = $faker->randomElements($tagsAll, 3);

            foreach ($tags as $tag) {
                $postTag = [
                    'post_id' => $postId,
                    'tag_id' => $tag['id']
                ];

                DB::table('post_tags')->insert($postTag);
            }
        }

        Post::createIndex($shards = null, $replicas = null);
        Post::putMapping($ignoreConflicts = true);
        Post::addAllToIndex();
    }
}
