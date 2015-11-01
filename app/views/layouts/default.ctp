<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="Better Than the Bookstore, buy and sell college textbooks, textbooks, college textbooks, university textbooks, new and used textbooks, used texbooks, new textbooks, student books, buy textbooks, sell textbooks, University of Pennsylvania, Drexel Univesity, Temple Univesity, Pennysylvania colleges, Pennsylvania universities, Philadephia, students, student, class textbooks, class books, book exchange, Philadelphia student books, books, buy and sell books, buy books, sell books">

<meta name="description" content="Better Than the Bookstore is an online source to buy and sell college textbooks">

<META Name="classification" Content="Better Than The Bookstore, books,">
<meta name="author" content="Better Than the Bookstore" />
<title>Better Than The Bookstore: Buy and Sell Used Textbooks</title>
<?php echo $html->css("mainstyle"); ?>

<style type="text/css">
<!--
-->
</style>
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function popup(mylink, windowname)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == 'string')
   href=mylink;
else
   href=mylink.href;
window.open(href, windowname, 'width=400,height=200,scrollbars=yes');
return false;
}
//-->
</script>

</head>
<body onload="MM_preloadImages('/img/icon-2.jpg','/img/button-overview-b.jpg','/img/button-better-b.jpg','/img/button-about-b.jpg','/img/button-compare-b.jpg','/img/button-work-b.jpg','/img/icon-1.jpg')">
<!-- start header -->
<div id="header">
	<div id="search">
		<form id="searchform" method="POST" action="/books/buy">
<fieldset>
	  <p align="right">
			  <input id="s" type="text" name="isbn" value="" class="text" />
			  <input id="x" type="submit" value="Search Books" class="button" />
	  </p>
	  <p align="right">
	  <?
		if ($is_admin)
		{
			echo $html->link("Admin Page", "/admin", array('class'=>'footertext'));
			echo "<br/>";
		}
	  ?>
	  <span class="footertext"><? if (isset($school_info)) { echo $school_info["School"]["name"]; } ?> 

	  <?

	  ?>
	  
	  (<a href="/books" class="footertext">Switch Schools</a>) |
	  <a href="/cart_items" class="footertext">My Cart</a> |
	  <?
	  	$sessioninfo = $session->read();
		$user_id = $session->read("Auth.User.user_id");
		#error_log("SESS=".print_r($sessioninfo,true));
	  	if ($user_id)
		{
			$first = $sessioninfo["Auth"]["User"]["first"];
			$last = $sessioninfo["Auth"]["User"]["last"];

			echo $html->link("My Account ($first $last)", "/users/account", array('class'=>'footertext')); ?> | <?
			echo $html->link("Logout", "/users/logout", array('class'=>'footertext'));
		} else {
			echo $html->link("Login", "/users/login", array('class'=>'footertext'));
		}

	  ?>
	  </span>
</fieldset>
		</form>
	</div>
</div>
<div id="logo"></div>
<!-- end header -->
<hr />
<!-- start page -->
    <?php if ($this->params['controller'] == 'pages' || ($this->params['controller'] == 'books' && $this->params['action'] == 'home')): ?>
		<div id="page2">
	<?php else: ?>
		<div id="page">
    <?php endif; ?>
  	
	<div id="menu">
		<ul>
			<li class="current_page_item"><a href="/pages/home" class="current_page_item">Home</a></li>
			<li><a href="/books/buy">Buy books </a></li>
			<li><a href="/books/sell">Sell Books </a></li>
			<li><a href="/pages/howto">How To </a></li>
			<li><a href="/pages/ethics">Ethics</a></li>
			<?
			if (!$user_id)
			{
				echo '<li><a href="/users/login">Login</a></li>';
			}
			?>
		</ul>
	</div>

   <?php if ($this->params['controller'] == 'pages' || ($this->params['controller'] == 'books' && $this->params['action'] == 'home')): ?>
	<div id="leftside">
      <ul class="avmenu">
        <li>
          <div align="left"><a href="/pages/home" class="navbar"></a><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','/img/icon-1.jpg',1)"></a><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('icon','','/img/icon-2.jpg',1)"></a><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image1','','/img/icon-2.jpg',1)"></a><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','/img/icon-1.jpg',1)"><img src="/img/icon-2.jpg" alt="Index" width="120" height="144" border="0" id="Image6" /></a><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','/img/icon-2.jpg',1)"></a><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','/img/icon-1.jpg',1)"></a></div>
        </li>

        <li><a href="/pages/home" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Overview','','/img/button-overview-b.jpg',1)"><img src="/img/button-overview-a.jpg" alt="Overview" width="110" height="33" hspace="0" vspace="0" border="0" id="Overview" /></a></li>
        <li class="navbar"></li>
        
        <li>
          <div align="left"><a href="/pages/gallery" class="navbar"></a><a href="better" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Better','','/img/button-better-b.jpg',1)"><img src="/img/button-better-a.jpg" alt="Better" width="110" height="33" hspace="0" vspace="2" border="0" id="Better" /></a></div>
        </li>
        <li>
          <div align="left"><a href="/pages/about" class="navbar"></a><a href="/pages/about" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('About','','/img/button-about-b.jpg',1)"><img src="/img/button-about-a.jpg" alt="About" width="110" height="33" hspace="0" vspace="2" border="0" id="About" /></a></div>
        </li>
		       <li>
          <div align="left"><a href="/pages/compare" class="navbar"></a><a href="/pages/compare" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Compare','','/img/button-compare-b.jpg',1)"><img src="/img/button-compare-a.jpg" alt="Compare" width="110" height="33" vspace="2" border="0" id="Compare" /></a></div>
        </li>
		     <li>
          <div align="left"><a href="/pages/work" class="navbar"></a><a href="/pages/work" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Work','','/img/button-work-b.jpg',1)"><img src="/img/button-work-a.jpg" alt="Work" width="110" height="33" hspace="0" vspace="2" border="0" id="Work" /></a></div>
        </li>
      </ul>

  </div>
	<?php else: ?>
   <div id="leftside">
  	<img src="http://www.betterthanthebookstore.com/design/img/sideicon.jpg" alt="" width="120" height="590" border="0" align="top"/>
   </div>
  <?php endif; ?>

	<!-- start content -->
  <div id="content">
	<?php
        	if ($session->check('Message.flash')):
        		$session->flash();
        	endif;
	?>

  	<?php echo $content_for_layout; ?>
  </div>
	<!-- end content -->

  <?php if ($this->params['controller'] == 'pages' || ($this->params['controller'] == 'books' && $this->params['action'] == 'home')): ?>
  <!-- start sidebar two -->
  <div id="sidebar2" class="sidebar">
   <ul>
	    <li class="sidebarheader">at a glance:</li>
	    <li class="sidebartext">Books for Sale: <br />
          <span class="sidebarheader">2096</span></li>
	    <li class="sidebartext">Registered Users: <br />
          <span class="sidebarheader">9487</span></li>
	    <li class="sidebartext">Money You've Saved: <span class="sidebarheader">$586,998</span></li>
	    <li class="sidebartext">Fuel Saved: <br />
          <span class="sidebarheader">76,099 gal.    </span></li>
	    <li class="sidebartext">Trees Saved: <br />
          <span class="sidebarheader">3,873 </span></li>
    </ul>
    </div>
  <!-- end sidebar two -->
  <?php endif; ?>

	<div style="clear: both;"></div>
</div>
<!-- end page -->
<hr />
<!-- start footer -->
<div id="footer">
	<p><a href="/pages/home">Index</a> | &copy; 2008 Better Than The Bookstore LLC | <a href="/pages/terms">Terms of Service</a> | <a href="/pages/privacy">Privacy Policy</a> | <a href="/pages/contact">Contact</a></p>
</div>
<!-- end footer -->
</body>
</html>
