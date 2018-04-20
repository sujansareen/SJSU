<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class VideoProducts extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $this->createProductsTable();
        $this->addProducts();
    }
    public function createProductsTable() {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('img');
            $table->string('url');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }

    public function addProducts() {
        $locations = [
            [
                "name" => "Šolta, Croatia",
                "description" => "The jewel of the Adriatic Sea, Croatia is home to more than 1,200 islands, but travel between them has long been dictated by expensive yacht charters and sluggish public ferries.",
                "img" => "solta-croatia",
                "url" => "",
            ],
            [
                "name" => "Greenville, South Carolina",
                "description" => "Once a sleepy second fiddle to Southern culinary powerhouses like Charleston and Nashville, Greenville is stepping into the limelight with hot new restaurants.",
                "img" => "greenville-southCarolina",
                "url" => "",
            ],
            [
                "name" => "Grenada",
                "description" => "Grenada, known as Spice Island, remains one of the Caribbean’s under-the-radar gems, even though it’s got what every traveler wants: uncrowded beaches, preserved rain forests, and a lively local culture and cuisine.",
                "img" => "grenada",
                "url" => "",
            ],
            [
                "name" => "Buenos Aires, Argentina",
                "description" => "This year, Buenos Aires becomes a hub for art, sports, and politics: the inaugural Art Basel Cities program, the Youth Olympic Games, and the G20 will all take place in the city, beginning with the multi-year Art Basel initiative.",
                "img" => "buenosAires-argentina",
                "url" => "",
            ],
            [
                "name" => "losCabos-mexico",
                "description" => "Located at the tip of the Baja Peninsula, the two small colonial towns of Cabo San Lucas and San José del Cabo have become the hottest vacation destinations in Mexico in recent years. ",
                "img" => "",
                "url" => "",
            ],
            [
                "name" => "Walla Walla Valley, Washington",
                "description" => "With more than 300 days of sunshine each year, the southeastern corner of Washington state is home to three flourishing viticultural regions: the Columbia, Walla Walla, and Yakima Valleys.",
                "img" => "wallaWallaValley-washington",
                "url" => "",
            ],
            [
                "name" => "Uzbekistan",
                "description" => "Although the former Soviet republic might seem remote, Uzbekistan once sat at the very center of the world.",
                "img" => "uzbekistan",
                "url" => "",
            ],
            [
                "name" => "Egypt",
                "description" => "Political strife and economic woes have taken a toll on Egypt’s tourism industry in recent years, but travelers will soon have a new reason to visit.",
                "img" => "egypt",
                "url" => "",
            ],
            [
                "name" => "Marrakesh, Morocco",
                "description" => "The Moroccan city has attracted an artistic crowd since the 1960s, when everyone from Yves Saint Laurent to Mick Jagger fell for its vibrant sensory landscape.",
                "img" => "marrakesh-morocco",
                "url" => "",
            ],
            [
                "name" => "Fiji",
                "description" => "It’s no secret that Fiji is home to some of the world’s most spectacular scenery — powdery beaches fringed with palms, crystalline waters with colorful reefs, and rugged coastlines covered in greenery.",
                "img" => "fiji",
                "url" => "",
            ],
            [
                "name" => "Albuquerque, New Mexico",
                "description" => "Rising above its associations with the annual hot-air-balloon festival, Albuquerque will this year set out to prove itself as a fully-fledged destination.",
                "img" => "albuquerque-newMexico",
                "url" => "",
            ]

        ];
        foreach ($locations as $key=>$location) {
            $id     = DB::table('products')->insertGetId( $location );
            echo sprintf("Added %s to products - %s \n", array_get($location,'name','') , $id);
        }
    }

}
