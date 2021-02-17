<?php

namespace Database\Seeders;

use App\Models\GameProvider;
use Illuminate\Database\Seeder;

class GameProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$providers = [
        //    'authentic',
        //    'ganapati',
        //    'yggdrasil',
        //    'netentse',
        //    'amatic',
        //    'greentube',
        //    'genii',
        //    'multishot',
        //    'nektan',
        //    'playtech',
        //    'nyx',
        //    'evolution',
        //    'nolimit',
        //    'isoftbet',
        //    'quickspin',
        //    'playngo',
        //    'thunderkick',
        //    'pragmatic',
        //    'spigo',
        //    'oryx',
        //    'stakelogic',
        //    'pariplay',
        //    'egt',
        //    'leander',
        //    'igt',
        //    'edict',
        //    'bsg',
        //    'ggi_quickfire',
        //    'netentit',
        //    'endorphina',
        //    'redtiger',
        //    'wazdan',
        //    'skywind',
        //    'tomhorn',
        //    'beefee',
        //    'portomaso'
        //];

        GameProvider::create([
            'name' => 'Play\'N Go',
            'location_match' => 'playngo'
        ]);

        GameProvider::create([
            'name' => 'Pragmatic',
            'location_match' => 'pragmatic'
        ]);

        GameProvider::create([
            'name' => 'Netent IT',
            'location_match' => 'netentit'
        ]);
    }
}
