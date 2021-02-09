<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $microgames = [
            'authentic',
            'ganapati',
            'yggdrasil',
            'netentse',
            'amatic',
            'greentube',
            'genii',
            'multishot',
            'nektan',
            'playtech',
            'nyx',
            'evolution',
            'nolimit',
            'isoftbet',
            'quickspin',
            'playngo',
            'thunderkick',
            'pragmatic',
            'spigo',
            'oryx',
            'stakelogic',
            'pariplay',
            'egt',
            'leander',
            'igt',
            'edict',
            'bsg',
            'ggi_quickfire',
            'netentit',
            'endorphina',
            'redtiger',
            'wazdan',
            'skywind',
            'tomhorn',
            'beefee',
            'portomaso'
        ];

        foreach($microgames as $microgame) {
            Location::create([
                'name'       => $microgame,
                'modifier'   => '^~',
                'match'      => "/diamondbet/soap/{$microgame}.php",
                'options'    => '',
                'is_enabled' => true
            ]);
        }
    }
}
