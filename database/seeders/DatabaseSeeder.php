<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\t_notification;
use App\Models\t_lampadaire;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $notif = new t_lampadaire;
        // $notif->address = "Place de, Gal Saint-François 17, 1003 Lausanne";
        // $notif->longitude = 46.519495728434876;
        // $notif->latitude = 6.632675078212141;
        // $notif->save();

        $values = [
            [
                'title'=> 'Test Notification 1',
                'content'=> 'This is a test notification 1',
                'fkLampadaire' => 1
            ],
            [
                'title'=> 'Test Notification 2',
                'content'=> 'This is a test notification 2',
                'fkLampadaire' => 1
            ],
            [
                'title'=> 'Test Notification 3',
                'content'=> 'This is a test notification 3',
                'fkLampadaire' => 1
            ],
        ];

        
            foreach($values as $value) {
                $notif = new t_notification();
                $notif->title = $value['title'];
                $notif->content = $value['content'];
                $notif->fkLampadaire = $value['fkLampadaire'];
                $notif->save();
            };
    }
}
