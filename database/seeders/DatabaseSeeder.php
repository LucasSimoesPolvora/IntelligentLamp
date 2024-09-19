<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\t_notification;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $values = [
            [
                'title'=> 'Test Notification 1',
                'content'=> 'This is a test notification 1',
            ],
            [
                'title'=> 'Test Notification 2',
                'content'=> 'This is a test notification 2',
            ],
            [
                'title'=> 'Test Notification 3',
                'content'=> 'This is a test notification 3',
            ],
        ];

        
            foreach($values as $value) {
                $notif = new t_notification();
                $notif->title = $value['title'];
                $notif->content = $value['content'];
                $notif->save();
            };
    }
}
