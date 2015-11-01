	<p>
	  <!-- start content -->
  </p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p><span class="Headline">Better Than The Bookstore</span><br />
    <span class="subhead">Buy and Sell Used  Textbooks</span></p>
	<p style="height: 50px;"><span class="maintext">Not yet at your school?<br/> Select your school then click on 'Enter as Guest'</span>        </p>
	<?php
		echo $form->create(null,array('url'=>'/books/index'));
		$schoolmap = array();
		#echo "<select name='data[School][school_id]'>\n";
		#foreach ($schools as $school)
		#{
		#	$id = $school["School"]["school_id"];
		#	$name = $school["School"]["name"];
		#	echo "<option value='$id'>$name</option>\n";
		#}
		#echo "</select>\n";
		#echo "<input type=submit name=submit value='Enter as Guest'>";
		#echo $form->end();

		# This stuff above is broken....

		foreach ($schools as $school)
		{
			$id = $school["School"]["school_id"];
			$name = $school["School"]["name"];
			$schoolmap[$id] = $name;
		}
		echo $form->input('School.school_id', array('options'=>$schoolmap, 'type'=>'select','label'=>""));
		echo $form->end('Enter as Guest');


		echo "<br/>Already have an account? ";
		echo $html->link('Click here to Login', "/users/login");
		echo "<br/>Want an account? ";
		echo $html->link('Click here to Signup', "/users/signup");
	?>
	<!--
	<hr/>
	<form name="input" action="html_form_action.asp" method="get">
	  <p class="maintext">
	    Drexel University: 
	      <input type="radio" name="School" value="Drexel University">
    <br>
	    Temple University: 
        <input type="radio" name="School" value="Temple University">
        <br />
        University of Pennsylvania:
        <input type="radio" name="School" value="University of Pennsylvania" />
	  </p>
	  <p class="maintext">	    <br>
	    <input type ="submit" value ="Submit">
      </p>
	  <p class="maintext">Not at your school  yet? <a href="/pages/home">Enter as a visitor</a></p>
	  <p class="maintext">&nbsp;</p>
	  <p class="maintext">&nbsp;</p>
	</form> 
	  -->

<div style="clear: both;">&nbsp;</div>
