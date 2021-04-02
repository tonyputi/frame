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
            'location_match' => '/diamondbet/soap/amatic.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Authentic',
            'location_match' => '/diamondbet/soap/authentic.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Beefee',
            'location_match' => '/diamondbet/soap/beefee.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'EGT',
            'location_match' => '/diamondbet/soap/egt.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Endorphina',
            'location_match' => '/diamondbet/soap/endorphina.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Evolution',
            'location_match' => '/diamondbet/soap/evolution.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Ganapati',
            'location_match' => '/diamondbet/soap/ganapati.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Genii',
            'location_match' => '/diamondbet/soap/genii.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Greentube',
            'location_match' => '/diamondbet/soap/greentube.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Multishot',
            'location_match' => '/diamondbet/soap/multishot.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Netent IT',
            'location_match' => '/diamondbet/soap/netentit.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Netent SE',
            'location_match' => '/diamondbet/soap/netentse.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Nektan',
            'location_match' => '/diamondbet/soap/nektan.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Nyx',
            'location_match' => '/diamondbet/soap/nyx.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Oryx',
            'location_match' => '/diamondbet/soap/oryx.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Play\'N Go',
            'location_match' => '/diamondbet/soap/playngo.php',
            'default_redirect_to' => 'stage-it.videoslots.com',
            'default_redirect_ipv4' => '192.168.0.28'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Playtech',
            'location_match' => '/diamondbet/soap/playtech.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Portomaso',
            'location_match' => '/diamondbet/soap/portomaso.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Pragmatic',
            'location_match' => '/diamondbet/soap/pragmatic.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Quickspin',
            'location_match' => '/diamondbet/soap/quickspin.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Spigo',
            'location_match' => '/diamondbet/soap/spigo.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Skywind',
            'location_match' => '/diamondbet/soap/skywind.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Thunderkick',
            'location_match' => '/diamondbet/soap/thunderkick.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Tomhorn',
            'location_match' => '/diamondbet/soap/tomhorn.php'
        ]);

        Location::create([
            'environment_id' => 1,
            'name' => 'Yggdrasil',
            'location_match' => '/diamondbet/soap/yggdrasil.php'
        ]);
    }
}
