<?php

use App\Post;
use App\User;
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
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@inertia-news.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        $editor = User::create([
            'name' => 'editor',
            'email' => 'editor@inertia-news.com',
            'password' => bcrypt('secret'),
            'role' => 'editor',
        ]);

        factory(Post::class, 10)->create([
            'author_id' => function () use ($admin, $editor) {
                return rand(0, 1) ? $admin->id : $editor->id;
            },
        ]);
    }
}
