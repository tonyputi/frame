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
        GameProvider::create([
            'name' => 'Amatic',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/amatic.php'
        ]);

        GameProvider::create([
            'name' => 'Authentic',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/authentic.php'
        ]);

        GameProvider::create([
            'name' => 'Beefee',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/beefee.php'
        ]);

        GameProvider::create([
            'name' => 'EGT',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/egt.php'
        ]);

        GameProvider::create([
            'name' => 'Endorphina',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/endorphina.php'
        ]);

        GameProvider::create([
            'name' => 'Evolution',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/evolution.php'
        ]);

        GameProvider::create([
            'name' => 'Ganapati',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/ganapati.php'
        ]);

        GameProvider::create([
            'name' => 'Genii',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/genii.php'
        ]);

        GameProvider::create([
            'name' => 'Greentube',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/greentube.php'
        ]);

        GameProvider::create([
            'name' => 'Multishot',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/multishot.php'
        ]);

        GameProvider::create([
            'name' => 'Netent IT',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/netentit.php'
        ]);

        GameProvider::create([
            'name' => 'Netent SE',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/netentse.php'
        ]);

        GameProvider::create([
            'name' => 'Nektan',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/nektan.php'
        ]);

        GameProvider::create([
            'name' => 'Nyx',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/nyx.php'
        ]);

        GameProvider::create([
            'name' => 'Oryx',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/oryx.php'
        ]);

        GameProvider::create([
            'name' => 'Play\'N Go',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/playngo.php',
            'default_host' => 'stage-it.videoslots.com'
        ]);

        GameProvider::create([
            'name' => 'Playtech',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/playtech.php'
        ]);

        GameProvider::create([
            'name' => 'Portomaso',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/portomaso.php'
        ]);

        GameProvider::create([
            'name' => 'Pragmatic',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/pragmatic.php'
        ]);

        GameProvider::create([
            'name' => 'Quickspin',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/quickspin.php'
        ]);

        GameProvider::create([
            'name' => 'Spigo',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/spigo.php'
        ]);

        GameProvider::create([
            'name' => 'Skywind',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/skywind.php'
        ]);

        GameProvider::create([
            'name' => 'Thunderkick',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/thunderkick.php'
        ]);

        GameProvider::create([
            'name' => 'Tomhorn',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/tomhorn.php'
        ]);

        GameProvider::create([
            'name' => 'Yggdrasil',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/yggdrasil.php'
        ]);
    }
}
