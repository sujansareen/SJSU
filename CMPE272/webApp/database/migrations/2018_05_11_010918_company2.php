<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->addProducts();

    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('products')->where('company_id', 2)->delete();
    }

    public function addProducts() {
        $locations = [
            [
                "name" => "collaboration",
                "description" => "As people who are passionate about stories being told via art, we would prefer to sit down and chat to better gauge what you want and allow you to work directly alongside us in the creative process. Otherwise contact us and give us a call and we will find alternatives to assist as best we can.",
                "img" => "images/service images/collaboration.png",
                "url" => "collaborationinfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [
                "name" => "promotion",
                "description" => "Depending on the kind of attention and audience you want to work to attract, we tailor a marketing strategy for you via internet and social media.",
                "img" => "images/service images/Promoting.jpg",
                "url" => "promotioninfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [    
                "name" => "networking",
                "description" => "We look for like-minded people that can work with you and fit on your team in order to create new groups capable of flourishing as a production studio.",
                "img" => "images/service images/Networking.jpg",
                "url" => "networkinfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [
                "name" => "sketch",
                "description" => "We offer sessions with an artist who can sketch out a visual representation of what you want, if needed.",
                "img" => "images/service images/Sketch.jpg",
                "url" => "sketchinfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [
                "name" => "3dmodelinfo",
                "description" => "Skilled 3D modelers with technologies such as Blender and Maya are on our team and ready to create ready-to-use models for your projects.",
                "img" => "images/service images/3D Modeling.jpg",
                "url" => "3dmodelinfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [
                "name" => "3danimation",
                "description" => "As well as modelers, people with experience in 3D animation can assist with game and or cinematic animation.",
                "img" => "images/service images/3D Animation.jpg",
                "url" => "3danimation.php",
                "service" => false,
				"company_id" => 2,
            ],
            [
                "name" => "characterdesign",
                "description" => "If you have need for distinctive character looks, we can help with that.",
                "img" => "images/service images/Character Design.jpg",
                "url" => "characterdesigninfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [    
                "name" => "digitalart",
                "description" => "You can request digital art commissions by one of our artists.",
                "img" => "images/service images/Digital Art.JPG",
                "url" => "digitalartinfo.php",
                "service" => false,
				"company_id" => 2,
            ],   
            [
                "name" => "2danimation",
                "description" => "Whether it's for music videos or anything else, we make use of Adobe software to render and edit our animations in videos.",
                "img" => "images/service images/2D Animation.gif",
                "url" => "2danimationinfo.php",
                "service" => false,
				"company_id" => 2,
            ],
            [
                "name" => "gamedesign",
                "description" => "As both gamers and storytellers, we are familar with Unity and Unreal's game design tools and will use it to realize your vision if you decide a game is the best medium for it.",
                "img" => "images/service images/Game Design.jpg",
                "url" => "gamedesigninfo.php",
                "service" => false,
				"company_id" => 2,
            ],
        ];
        foreach ($locations as $key=>$location) {
            $id     = DB::table('products')->insertGetId( $location );
            echo sprintf("Added %s to products - %s \n", array_get($location,'name','') , $id);
        } 
    }
}
