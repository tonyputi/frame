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
            'name' => 'Amatic',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/amatic.php'
        ]);

        Location::create([
            'name' => 'Authentic',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/authentic.php'
        ]);

        Location::create([
            'name' => 'Beefee',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/beefee.php'
        ]);

        Location::create([
            'name' => 'EGT',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/egt.php'
        ]);

        Location::create([
            'name' => 'Endorphina',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/endorphina.php'
        ]);

        Location::create([
            'name' => 'Evolution',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/evolution.php'
        ]);

        Location::create([
            'name' => 'Ganapati',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/ganapati.php'
        ]);

        Location::create([
            'name' => 'Genii',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/genii.php'
        ]);

        Location::create([
            'name' => 'Greentube',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/greentube.php'
        ]);

        Location::create([
            'name' => 'Multishot',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/multishot.php'
        ]);

        Location::create([
            'name' => 'Netent IT',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/netentit.php'
        ]);

        Location::create([
            'name' => 'Netent SE',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/netentse.php'
        ]);

        Location::create([
            'name' => 'Nektan',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/nektan.php'
        ]);

        Location::create([
            'name' => 'Nyx',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/nyx.php'
        ]);

        Location::create([
            'name' => 'Oryx',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/oryx.php'
        ]);

        Location::create([
            'name' => 'Play\'N Go',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/playngo.php',
            'default_host' => 'stage-it.videoslots.com'
        ]);

        Location::create([
            'name' => 'Playtech',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/playtech.php'
        ]);

        Location::create([
            'name' => 'Portomaso',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/portomaso.php'
        ]);

        Location::create([
            'name' => 'Pragmatic',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/pragmatic.php'
        ]);

        Location::create([
            'name' => 'Quickspin',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/quickspin.php'
        ]);

        Location::create([
            'name' => 'Spigo',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/spigo.php'
        ]);

        Location::create([
            'name' => 'Skywind',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/skywind.php'
        ]);

        Location::create([
            'name' => 'Thunderkick',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/thunderkick.php'
        ]);

        Location::create([
            'name' => 'Tomhorn',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/tomhorn.php'
        ]);

        Location::create([
            'name' => 'Yggdrasil',
            'location_modifier' => '^~',
            'location_match' => '/diamondbet/soap/yggdrasil.php'
        ]);
    }
}
