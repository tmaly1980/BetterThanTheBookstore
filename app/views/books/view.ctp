<div class="books view">
<h2><?php  


__('Book');?></h2>

<?
	echo $this->element('book_info', array('book' => $book, 'show_best_price'=>true));


//	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'New','compare_mode'=>$compare_mode)); 
	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'Like New','compare_mode'=>$compare_mode)); 
//	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'Very New','compare_mode'=>$compare_mode)); 
	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'Very Good','compare_mode'=>$compare_mode)); 
	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'Good','compare_mode'=>$compare_mode)); 
	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'Acceptable','compare_mode'=>$compare_mode)); 
	echo $this->element("listings_group", array('book'=>$book, 'condition_id'=>'International','compare_mode'=>$compare_mode)); 

	if (!empty($amazon_compare_info))
	{
		echo $this->element("listings_compare_group", array('book'=>$book, 'compare_info'=>$amazon_compare_info));
	}
?>

</div>
