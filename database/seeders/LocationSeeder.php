<?php

namespace Database\Seeders;

use App\Models\Environment;
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
        Environment::each(function($environment) {

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Amatic',
                'match' => '/diamondbet/soap/amatic.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Authentic',
                'match' => '/diamondbet/soap/authentic.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Beefee',
                'match' => '/diamondbet/soap/beefee.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'EGT',
                'match' => '/diamondbet/soap/egt.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Endorphina',
                'match' => '/diamondbet/soap/endorphina.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Evolution',
                'match' => '/diamondbet/soap/evolution.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Ganapati',
                'match' => '/diamondbet/soap/ganapati.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Genii',
                'match' => '/diamondbet/soap/genii.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Greentube',
                'match' => '/diamondbet/soap/greentube.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Multishot',
                'match' => '/diamondbet/soap/multishot.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Netent IT',
                'match' => '/diamondbet/soap/netentit.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Netent SE',
                'match' => '/diamondbet/soap/netentse.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Nektan',
                'match' => '/diamondbet/soap/nektan.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Nyx',
                'match' => '/diamondbet/soap/nyx.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Oryx',
                'match' => '/diamondbet/soap/oryx.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Play\'N Go',
                'match' => '/diamondbet/soap/playngo.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Playtech',
                'match' => '/diamondbet/soap/playtech.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Portomaso',
                'match' => '/diamondbet/soap/portomaso.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Pragmatic',
                'match' => '/diamondbet/soap/pragmatic.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Quickspin',
                'match' => '/diamondbet/soap/quickspin.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Spigo',
                'match' => '/diamondbet/soap/spigo.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Skywind',
                'match' => '/diamondbet/soap/skywind.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Thunderkick',
                'match' => '/diamondbet/soap/thunderkick.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Tomhorn',
                'match' => '/diamondbet/soap/tomhorn.php'
            ]);

            Location::create([
                'environment_id' => $environment ->id,
                'name' => 'Yggdrasil',
                'match' => '/diamondbet/soap/yggdrasil.php'
            ]);
        });
    }
}
