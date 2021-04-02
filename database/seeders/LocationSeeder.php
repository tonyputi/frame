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
        Location::create([
            'environment_id' => 1,
            'name' => 'Amatic',
            'match' => '/diamondbet/soap/amatic.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Authentic',
            'match' => '/diamondbet/soap/authentic.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Beefee',
            'match' => '/diamondbet/soap/beefee.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'EGT',
            'match' => '/diamondbet/soap/egt.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Endorphina',
            'match' => '/diamondbet/soap/endorphina.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Evolution',
            'match' => '/diamondbet/soap/evolution.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Ganapati',
            'match' => '/diamondbet/soap/ganapati.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Genii',
            'match' => '/diamondbet/soap/genii.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Greentube',
            'match' => '/diamondbet/soap/greentube.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Multishot',
            'match' => '/diamondbet/soap/multishot.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Netent IT',
            'match' => '/diamondbet/soap/netentit.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Netent SE',
            'match' => '/diamondbet/soap/netentse.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Nektan',
            'match' => '/diamondbet/soap/nektan.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Nyx',
            'match' => '/diamondbet/soap/nyx.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Oryx',
            'match' => '/diamondbet/soap/oryx.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Play\'N Go',
            'match' => '/diamondbet/soap/playngo.php',
            'default_redirect_to' => 'stage-it.videoslots.com',
            'default_redirect_ipv4' => '192.168.0.28'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Playtech',
            'match' => '/diamondbet/soap/playtech.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Portomaso',
            'match' => '/diamondbet/soap/portomaso.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Pragmatic',
            'match' => '/diamondbet/soap/pragmatic.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Quickspin',
            'match' => '/diamondbet/soap/quickspin.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Spigo',
            'match' => '/diamondbet/soap/spigo.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Skywind',
            'match' => '/diamondbet/soap/skywind.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Thunderkick',
            'match' => '/diamondbet/soap/thunderkick.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Tomhorn',
            'match' => '/diamondbet/soap/tomhorn.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Yggdrasil',
            'match' => '/diamondbet/soap/yggdrasil.php'
        ]);
    }
}
