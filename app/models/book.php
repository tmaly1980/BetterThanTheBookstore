<?php
class Book extends AppModel {

	var $name = 'Book';
	var $primaryKey = 'book_id';
	var $validate = array(
		'book_id' => array('numeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'ActiveListing' => array('className' => 'ActiveListing',
								'foreignKey' => 'book_id',
								'dependent' => false,
								'conditions' => 'ActiveListing.paused != 1',
								'fields' => '',
								'order' => 'ActiveListing.price ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'RemovedListing' => array('className' => 'RemovedListing',
								'foreignKey' => 'book_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'RemovedListing.price ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'SoldListing' => array('className' => 'SoldListing',
								'foreignKey' => 'book_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => 'SoldListing.price ASC',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

	function get_isbn13($isbn)
	{
		# Remove non-alpha numeric (dashes, etc)
		$isbn = preg_replace('/\W+/', '', $isbn);

		if (strlen($isbn) < 13)
		{
			return $this->isbn10to13($isbn);
		} else {
			return $isbn;
		}
	}

 	function isbn10to13($isbn10) 
	{  
		if (strlen("$isbn10") < 10) { $isbn10 = sprintf("%010d", $isbn10); } # Assert 10 chars, not 9, etc. 
		
     		$isbn = trim($isbn10);  
     		if(strlen($isbn) == 12){ // if number is UPC just add zero  
         		$isbn13 = '0'.$isbn;}  
     		else  
     		{  
         		$isbn2 = substr("978" . trim($isbn), 0, -1);  
         		$sum13 = $this->genchksum13($isbn2);  
         		$isbn13 = "$isbn2$sum13";  
     		}  
     		return ($isbn13);  
 	}  

	function genchksum13($isbn10) 
	{  
     		$isbn = trim($isbn10);  
		$tb = 0;
     		for ($i = 0; $i <= 12; $i++) {  
         		$tc = substr($isbn, -1, 1);  
         		$isbn = substr($isbn, 0, -1);  
         		$ta = ($tc*3);  
         		$tci = substr($isbn, -1, 1);  
         		$isbn = substr($isbn, 0, -1);  
         		$tb = $tb + $ta + $tci;  
     		}  
     		$tg = ($tb / 10);  
     		$tint = intval($tg);  
     		if ($tint == $tg) { return 0; }  
     		$ts = substr($tg, -1, 1);  
     		$tsum = (10 - $ts);  
     		return $tsum;  
 	}  

	function ensure_and_find_byisbn($isbn)
	{ # If not in db, get from amazon, etc FIRST. return local entry after.
		$isbn13 = $this->get_isbn13($isbn);

		$entry = $this->find("isbn13 = '$isbn13'");

		if (!$entry) # ONLY get from remote site if not already here....
		{
			$this->retrieve_info_byisbn($isbn13);

			$entry = $this->find("isbn13 = '$isbn13'"); # Try again, now that we have it.
		}

		return $entry;
	}

	function retrieve_info_byisbn($isbn) # Since not in db, get from amazon, etc...
	{
		$isbn13 = $this->get_isbn13($isbn);

		$amazon_info = $this->get_amazon_bookinfo($isbn13); # Fields formatted like db....
		# FOR NOW, just get by amazon!!!! (if they dont have it, give up!)

		#error_log("AMAZON_INFO=".print_r($amazon_info, true));

		#error_log("FINDING ISBN=$isbn13");

		$entry = $this->find("isbn13 = '$isbn13'");
		if (!empty($entry))
		{
			$this->id = $entry["Book"]["book_id"]; # So know to update instead of insert...
			#error_log("UPDATING TO BOOK_ID=".$this->id);
		} else {
			#error_log("CREATING NEW ENTRY");
			$this->create();
		}

		$this->save(array('Book' => $amazon_info)); # Needs to be formatted as if form.

		# Download images and save them too....
		$img_path = APP . "webroot/img/bookcovers";
		$thumb_path = "$img_path/thumbs";

		if ($url = $amazon_info["imageFullURL"])
		{
			$imgcontent = file_get_contents($url);
			$file = fopen("$img_path/$isbn13.jpg", "w");
			fwrite($file, $imgcontent);
			fclose($file);
		}

		if ($url = $amazon_info["imageThumbURL"])
		{
			$imgcontent = file_get_contents($url);
			$file = fopen("$img_path/thumbs/$isbn13.jpg", "w");
			fwrite($file, $imgcontent);
			fclose($file);
		}

		# Try to find record in db so can override entry (and keep book_id for xref), to update info, etc.
		return $amazon_info;
	}

	function get_formatted_isbn13($isbn)
	{
		$isbn13 = $this->get_isbn13($isbn);
		# Put a dash after the 3rd char.
		$formatted = substr($isbn13, 0,3) . "-" . substr($isbn13, 3, strlen($isbn13) - 3);
		return $formatted;
	}

	function get_amazon_affiliate_url($isbn)
	{
		$isbn10 = $this->get_isbn10($isbn);
		$affiliate = "betterthanthe-20";
		$url = "http://www.amazon.com/exec/obidos/ASIN/$isbn10/$affiliate";
		return $url;
	}

	function get_amazon_compare_info($isbn)
	{
		$isbn10 = $this->get_isbn10($isbn);
		$isbn13 = $this->get_isbn13($isbn);
		$book = $this->find("isbn13 = '$isbn13'");

		# ALWAYS query amazon (tho dont bother updating book record)
		$amazon_info = $this->get_amazon_bookinfo($isbn10);
		$price = $amazon_info['amazonListPrice'];
		#error_log("AMAZON_LISTIN_INFO=".print_r($amazon_info,true));

		$compare_info = array();

		if ($amazon_info['amazonListPrice'])
		{
			$compare_info[] = array(
				'name'=>'Amazon.com (Direct)',
				'condition_id'=>'New',
				'url'=>$this->get_amazon_affiliate_url($isbn10),
				'info'=>$amazon_info,
				'price'=>$amazon_info['amazonListPrice'],
			);
		}
		if ($amazon_info['amazonNewPrice'])
		{
			$compare_info[] = array(
				'name'=>'Amazon.com (Third-Party)',
				'condition_id'=>'New',
				'url'=>$this->get_amazon_affiliate_url($isbn10),
				'info'=>$amazon_info,
				'price'=>$amazon_info['amazonNewPrice'],
			);
		}
		if ($amazon_info['amazonUsedPrice'])
		{
			$compare_info[] = array(
				'name'=>'Amazon.com (Third-Party)',
				'condition_id'=>'Used',
				'url'=>$this->get_amazon_affiliate_url($isbn10),
				'info'=>$amazon_info,
				'price'=>$amazon_info['amazonUsedPrice'],
			);
		}

		return $compare_info;
	}

	function get_isbn10($isbn)
	{
		# remove non-numbers (excluding X).
		$isbn = preg_replace("/[^0-9X]/", "", $isbn);

		# If 13, convert to 10
		# XXX TODO
		if (strlen($isbn) > 10) { $isbn = $this->isbn13to10($isbn); }

		if (strlen($isbn) < 10) # Pad with 0's
		{
			$isbn = sprintf("%010d", $isbn);
		}
		return $isbn;
	}

	function isbn13to10($isbn13)
	{
	    $isbn10 = "";
	    if ($isbn13==null)
	    {
	        return false;        
	    }
	    $isbn13 = str_replace(" ","",str_replace("-","",$isbn13));
	    $isbnLen=strlen($isbn13);
	    if ($isbnLen!=13)
	    {
	        //Invalid length
	        return false;
	    }
	
	    $isbn10 = substr($isbn13,3,9);
	    $sum = 0;
	    $isbnLen=strlen($isbn10);
	
	    for ($i = 0; $i < $isbnLen; $i++) 
	    {
	        $current = substr($isbn10,$i,1);
	        if($current<0||$current>9)
	        {
	            //Invalid ISBN
	            return false;
	        }
	        $sum+= $current*(10-$i);
	    }
	    $modulu = $sum%11;
	    $checkDigit = 11 - $modulu;
	
	    //if the checkDigit is 10 should be x
	    if ($checkDigit==10)
	        $isbn10 .= 'X';
	    else if($checkDigit==11)
	        $isbn10 .= '0';
	    else
	        $isbn10 .= $checkDigit;
	        
	    return $isbn10;
	}

	function is_isbn($isbn)
	{
		# Remove all non-alphanumeric. ie dashes, spaces, etc...
		$isbn = preg_replace("/\W/", "", $isbn);

		$length = strlen($isbn);

		if (preg_match('/^[0-9X]*$/', $isbn) && $length >= 9) { return true; } # Only numeric or X, and long enough...
		else { return false; }
	}


	function get_amazon_xml($isbn)
	{
		$isbn10 = $this->get_isbn10($isbn); # Amazon only takes ISBN 10's....

		# error_log($isbn10);

		//$xml = $this->getURL("http://www.amazon.com/gp/product/$isbn");
		$ACCESS_KEY = "0EMENPX8N2R698SFXN82";
		# Build URL to query based on ASIN and ACCESS_KEY
		$url = 'http://webservices.amazon.com/onca/xml?Service=AWSECommerceService';
		$url .= "&AWSAccessKeyId=$ACCESS_KEY";
		#$url .= "&Operation=ItemLookup&IdType=ASIN&ItemId=$isbn13formatted";
		$url .= "&Operation=ItemLookup&IdType=ASIN&ItemId=$isbn10";
		$url .= '&ResponseGroup=Medium,OfferFull';
		$xml_string = file_get_contents($url);

		#error_log($xml_string);

		if (preg_match("/is not a valid value for ItemId/", $xml_string)) { error_log($xml_string); return null; }
		#return "<errors><error>Invalid book isbn $isbn, $isbn10</error></errors>"; } # Invalid!

		return $xml_string;
	}

	function get_amazon_bookinfo($isbn)
	{
		$xml_string = $this->get_amazon_xml($isbn);
		if (!$xml_string || $xml_string == '') { return null; }
		return $this->parse_amazon_xml($xml_string);
	}

	function parse_amazon_xml($xml_string)
	{
		$xmlobj = new SimpleXMLElement($xml_string);
		$xmlobj->registerXPathNamespace("a", "http://webservices.amazon.com/AWSECommerceService/2005-10-05");
		# Not a single reference to any tag by name will work without prepending 'a:', even w/o namespace!

		# Save in a hash appropriate for saving to db...
		# (plus extra stuff like thumbnail urls...)
		$review = $xmlobj->Items->Item[0]->EditorialReviews->EditorialReview;


		$authors = array();
		foreach ($xmlobj->Items->Item[0]->ItemAttributes->Author as $author)
		{
			$authors[] = (string) $author;
		}

		#$lowestNewPrice = 
		#Items->Item[0]->OfferSummary->LowestNewPrice->Amount;
		#$lowestUsedPrice = $xmlobj->xpath('');
		#$xmlobj->Items->Item[0]->OfferSummary->LowestUsedPrice->Amount;

		$str = $xmlobj->asXML();
		#$str = preg_replace("/></", ">\n<", $str);
		#print_r($str);
		#$p = $xmlobj->xpath('/a:Items/a:Item[0]/a:Offers/a:Offer[0]/a:OfferListing/a:Price/a:Amount');

		$retail_prices = $xmlobj->xpath('//a:Items/a:Item[1]/a:ItemAttributes/a:ListPrice/a:Amount');
				#((string) $xmlobj->Items->Item[0]->ItemAttributes->ListPrice->Amount) / 100),
		$retail_price = count($retail_prices) ? sprintf("%.02f", $retail_prices[0] / 100) : "";

		$used_prices = $xmlobj->xpath('//a:Items/a:Item[1]/a:OfferSummary/a:LowestUsedPrice/a:Amount');
		$used_price = count($used_prices) ? sprintf("%.02f", $used_prices[0] / 100) : "";

		$list_prices = $xmlobj->xpath('//a:Items/a:Item[1]/a:Offers/a:Offer[0]/a:OfferListing/a:Price/a:Amount');
		$list_price = count($list_prices) ? sprintf("%.02f", $list_prices[0] / 100) : "";
			#	((string) $xmlobj->Items->Item[0]->Offers->Offer[0]->OfferListing->Price->Amount) / 100),

		$new_prices = $xmlobj->xpath('//a:Items/a:Item[1]/a:OfferSummary/a:LowestNewPrice/a:Amount');
		$new_price = count($new_prices) ? sprintf("%.02f", $new_prices[0] / 100) : "";

		$info = array(
			"title" => (string) $xmlobj->Items->Item[0]->ItemAttributes->Title,
			"imageFullURL" => (string) $xmlobj->Items->Item[0]->MediumImage->URL,
			"imageThumbURL" => (string) $xmlobj->Items->Item[0]->SmallImage->URL,
			"isbn10" => (string) $xmlobj->Items->Item[0]->ItemAttributes->ISBN,
			"isbn13" => (string) $xmlobj->Items->Item[0]->ItemAttributes->EAN,
			"author" => (string) implode(", ", $authors),
			"format" => (string) $xmlobj->Items->Item[0]->ItemAttributes->Binding,
			"edition" => (string) $xmlobj->Items->Item[0]->ItemAttributes->Edition,
			"pubdate" => ((string) $xmlobj->Items->Item[0]->ItemAttributes->PublicationDate) . "-01",
				# need to add day there....
			"amazonRetailPrice" => $retail_price,
			"amazonUsedPrice" => $used_price,
			"amazonListPrice" => $list_price,
			"amazonNewPrice" => $new_price,
			"publisher" => (string) $xmlobj->Items->Item[0]->ItemAttributes->Publisher,
			"pages" => (string) $xmlobj->Items->Item[0]->ItemAttributes->NumberOfPages,
			"description" => (count($review) ? (string) $review[0]->Content : ""),

			# CAN eventually get ListPrice, etc.......
		);
		if (!$info["edition"]) { $info["edition"] = ''; } # Default. (dont want to show '0')

		return $info;
	}

	function get_topsellers($limit = 6)
	{
		$where_school = $this->where_school('active_listings');
	 	return $this->query("SELECT COUNT(*) AS salecount, MIN(active_listings.price) AS lowestprice, books.* FROM sold_listings, sales, books LEFT JOIN active_listings ON books.book_id = active_listings.book_id AND active_listings.price > 0 WHERE sold_listings.book_id = books.book_id AND sold_listings.sale_id = sales.sale_id $where_school GROUP BY sold_listings.book_id ORDER BY salecount DESC LIMIT $limit");
	}

	function set_school($school_id)
	{
		$this->school_id = $school_id;
		$this->bindModel(
			array('hasMany'=>array(
				'MySchoolActiveListing' =>array(
					'className' => 'ActiveListing',
					'foreignKey' => 'book_id',
					'dependent' => false,
					'order' => 'MySchoolActiveListing.price ASC',
					'conditions' => "MySchoolActiveListing.school_id = '$school_id' AND MySchoolActiveListing.paused != 1",
				),
			))
		);
		#$this->hasMany['ActiveListing']['conditions'] = '
	}

	function get_sales_stats($isbn)
	{
		$isbn13 = $this->get_isbn13($isbn);

		# Current Price Range:  	$xx.xx - $xx.xx
		#Last Sold Price: 	$xx.xx
		#Average Sold Price: 	$xx.xx
		#Lowest Like New Price:

		$stats = array(
			'low_price'=>'',
			'high_price'=>'',
			'last_sold_price'=>'',
			'avg_sold_price'=>'',
			'lowest_likenew_price'=>'',
		);

		$results_range = $this->query("SELECT MIN(a.price) AS low_price, MAX(a.price) AS high_price FROM books b LEFT JOIN active_listings a ON b.book_id = a.book_id WHERE b.isbn13 = '$isbn13' GROUP BY b.isbn13");
		$results_lastsold = $this->query("SELECT s.price AS last_sold_price FROM books b LEFT JOIN sold_listings s ON b.book_id = s.book_id LEFT JOIN sales ON s.sale_id = sales.sale_id WHERE b.isbn13 = '$isbn13' ORDER BY sales.time DESC LIMIT 1");
		$results_avgsold = $this->query("SELECT AVG(s.price) AS avg_sold_price FROM books b LEFT JOIN sold_listings s ON b.book_id = s.book_id LEFT JOIN sales ON s.sale_id = sales.sale_id WHERE b.isbn13 = '$isbn13' GROUP BY b.isbn13");
		$results_lowest_likenew = $this->query("SELECT MIN(a.price) AS lowest_likenew_price FROM books b LEFT JOIN active_listings a ON b.book_id = a.book_id WHERE b.isbn13 = '$isbn13' AND condition_id = 'Like New' GROUP BY b.isbn13");

		if (isset($results_range[0][0])) { $stats = array_merge($stats, $results_range[0][0]); }
		if (isset($results_lastsold[0][0])) { $stats = array_merge($stats, $results_lastsold[0][0]); }
		if (isset($results_avgsold[0][0])) { $stats = array_merge($stats, $results_avgsold[0][0]); }
		if (isset($results_lowest_likenew[0][0])) { $stats = array_merge($stats, $results_lowest_likenew[0][0]); }

		#error_log("RESULTS_R=".print_r($results_range,true));
		#error_log("STATS=".print_r($stats,true));
		return $stats;
	}

}
?>
