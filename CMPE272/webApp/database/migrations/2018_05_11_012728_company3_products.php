<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company3Products extends Migration
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
        //Schema::dropIfExists('products');
    }

    public function addProducts() {
        $locations = [
            [
                "name" => "Consultation",
                "description" => "is one of the service we provided. We will have our experts consult with you in person or by call. ",
                "img" => "/images/Services/Consultation.png",
                "url" => "/pages/Consultation.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Schematic Design",
                "description" => "is one of the service we provided. We will have our experts design a board schematic according to your design Criteria. ",
                "img" => "/images/Services/SchematicDesign.png",
                "url" => "/pages/SchematicDesign.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Schematic Testing",
                "description" => "is one of the service we provided. We will have our experts verify the schematic design that you provide. (Note that schematic testing is included if you are using our design) ",
                "img" => "/images/Services/SchematicTesting.png",
                "url" => "/pages/SchematicTesting.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Board Design",
                "description" => "is one of the service we provided. We will have our experts design a board layout based on the schematic diagram. ",
                "img" => "/images/Services/BoardDesign.png",
                "url" => "/pages/BoardDesign.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Board Verification",
                "description" => "is one of the service we provided. Before fabrication, We will have our experts verify the board design. This is part of the pre-silicon process. ",
                "img" => "/images/Services/BoardVerification.png",
                "url" => "/pages/BoardVerification.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Board Fabrication",
                "description" => "is one of the service we provided. We will handle all communication to make sure that your baord is successfully manufactured. ",
                "img" => "/images/Services/BoardFabrication.png",
                "url" => "/pages/BoardFabrication.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Board Assembly",
                "description" => "is one of the service we provided. Note that we will provide basic testing along with our assembly service. ",
                "img" => "/images/Services/BoardAssembly.png",
                "url" => "/pages/BoardAssembly.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Board Testing",
                "description" => "is one of the service we provided. We will have our experts test the PCB board you provided. ",
                "img" => "/images/Services/BoardTesting.png",
                "url" => "/pages/BoardTesting.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Firmware Design",
                "description" => "is one of the service we provided. We will have our experts (we specialize in ARM based processor) design the firmware for your application. ",
                "img" => "/images/Services/FirmwareDesign.png",
                "url" => "/pages/FirmwareDesign.php",
				"service" => false,
				"company_id" => 3,
            ],
            [
                "name" => "Firmware Verification",
                "description" => "is one of the service we provided. We will have our experts to verify the Firmware you have developed.Note that we will automatically verify our firwmare if you use our service to design it. ",
                "img" => "/images/Services/FirmwareVerification.png",
                "url" => "/pages/FirmwareVerification.php",
				"service" => false,
				"company_id" => 3,
            ]      
        ];
        foreach ($locations as $key=>$location) {
            $id     = DB::table('products')->insertGetId( $location );
            echo sprintf("Added %s to products - %s \n", array_get($location,'name','') , $id);
        }
    }
}
