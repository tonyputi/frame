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
            'location_match' => '/diamondbet/soap/playngo.php'
        ]);

        GameProvider::create([
            'name' => 'Pragmatic',
            'location_match' => '/diamondbet/soap/pragmatic.php'
        ]);

        GameProvider::create([
            'name' => 'Netent IT',
            'location_match' => '/diamondbet/soap/netentit.php'
        ]);

        GameProvider::create([
            'name' => 'Evolution',
            'location_match' => '/diamondbet/soap/evolution.php'
        ]);
    }
}
