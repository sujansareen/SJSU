<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company4 extends Migration
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
        DB::table('products')->where('company_id', 4)->delete();
    }
    public function addProducts() {
        $locations = [
            [
                "name" => "Product ID: ABB1",
                "description" => "Paperback: 448 pages
                Publisher: Grand Central Publishing; Reprint edition (October 24, 2017)
                Language: English
                ISBN-10: 1455542679
                ISBN-13: 978-1455542673
                Product Dimensions: 5.2 x 1.1 x 8 inches
                Shipping Weight: 15.2 ounces",
                "img" => "/wp-content/uploads/2018/03/book10-e1524197155696.jpg",
                "url" => "/blackBook.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB2",
                "description" => "Age Range: 10 - 12 years
                Grade Level: 5 - 7
                Paperback: 128 pages
                Publisher: HMH Books for Young Readers; Reprint edition (October 4, 2011)
                Language: English
                ISBN-10: 0547577311
                ISBN-13: 978-0547577319
                Product Dimensions: 5 x 0.2 x 8 inches
                Shipping Weight: 3.2 ounces",
                "img" => "/wp-content/uploads/2018/03/book11-e1524197303139.jpg",
                "url" => "/longWalk.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB3",
                "description" => "Paperback: 640 pages
                Publisher: Zondervan (February 1, 1996)
                Language: English
                ISBN-10: 0310220211
                ISBN-13: 978-0310220213
                Product Dimensions: 6 x 1.7 x 9 inches
                Shipping Weight: 2.3 pounds",
                "img" => "/wp-content/uploads/2018/03/book2.jpg",
                "url" => "/bookGod.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB4",
                "description" => "Paperback: 597 pages
                Publisher: Anchor (March 31, 2009)
                Language: English
                ISBN-10: 0307474275
                ISBN-13: 978-0307474278
                Product Dimensions: 4.1 x 1.5 x 7.5 inches
                Shipping Weight: 10.4 ounces",
                "img" => "/wp-content/uploads/2018/03/book9-e1524197348470.jpg",
                "url" => "/DaVinci.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB5",
                "description" =>"Paperback: 480 pages
                Publisher: Riverhead Books; Reprint edition (January 7, 2014)
                Language: English
                ISBN-10: 1594632324
                ISBN-13: 978-1594632327
                Product Dimensions: 5.2 x 1 x 8 inches
                Shipping Weight: 12 ounces",
                "img" => "/wp-content/uploads/2018/03/book7.jpg",
                "url" => "/teaspoon.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB6",
                "description" => "File Size: 822 KB
                Print Length: 348 pages
                Publisher: Harper (July 8, 2014)
                Publication Date: July 8, 2014
                Language: English
                ASIN: B00K0OI42W",
                "img" => "/wp-content/uploads/2018/03/book3.jpg",
                "url" => "/beautifulDisaster.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB7",
                "description" => "Age Range: 12 and up 
                Grade Level: 7 and up
                Lexile Measure: 730L (What's this?)
                Paperback: 592 pages
                Publisher: Alfred A. Knopf; Reprint edition (September 11, 2007)
                Language: English
                ISBN-10: 0375842209
                ISBN-13: 978-0375842207
                Product Dimensions: 5.1 x 1.2 x 8 inches
                Shipping Weight: 15.2 ounces",
                "img" => "/wp-content/uploads/2018/03/book6.jpg",
                "url" => "/bookThief.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB8",
                "description" => "Paperback: 1168 pages
                Publisher: Scribner; Reissue edition (January 5, 2016)
                Language: English
                ISBN-10: 1501142976
                ISBN-13: 978-1501142970
                Product Dimensions: 5.5 x 2 x 8.4 inches
                Shipping Weight: 2.2 pounds",
                "img" => "/wp-content/uploads/2018/03/book5.jpg",
                "url" => "/it.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB9",
                "description" => "Series: The Book of Dust (Book 1)
                Hardcover: 464 pages
                Publisher: Knopf Books for Young Readers; First Edition edition (October 19, 2017)
                Language: English
                ISBN-10: 0375815309
                ISBN-13: 978-0375815300
                Product Dimensions: 6.7 x 1.4 x 9.3 inches
                Shipping Weight: 1.8 pounds ",
                "img" => "/wp-content/uploads/2018/03/book4.jpg",
                "url" => "/bookDust.php",
                "service" => false,
				"company_id" => 4,
            ],
            [
                "name" => "Product ID: ABB10",
                "description" => "File Size: 822 KB
                Print Length: 348 pages
                Publisher: Harper (July 8, 2014)
                Publication Date: July 8, 2014
                Language: English
                ASIN: B00K0OI42W ",
                "img" => "/wp-content/uploads/2018/04/10.jpg",
                "url" => "/mockingbird.php",
                "service" => false,
				"company_id" => 4,
            ]
        ];
        foreach ($locations as $key=>$location) {
            $id     = DB::table('products')->insertGetId( $location );
            echo sprintf("Added %s to products - %s \n", array_get($location,'name','') , $id);
        } 
    }
}
