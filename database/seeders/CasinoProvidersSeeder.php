<?php

namespace Database\Seeders;

use App\Models\CasinoProvider;
use Illuminate\Database\Seeder;

class CasinoProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $providers = [
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

        foreach($providers as $provider) {
            CasinoProvider::create([
                'name' => $provider,
            ]);
        }
    }
}
