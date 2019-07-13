<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- TemplateBeginEditable name="doctitle" -->
<title>Rajkiya Engineering College Banda | Hostels</title>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="../js/rec.js"></script>
 
</head>

<body>
<div id="container"> 
  <header>
  	<img src="../image/about_logo (1).png" width="85" height="76" alt=""/>
  	<div id="header-text">Rajkiya Engineering College, Banda Hostels</div>
  </header>
  <nav>
  	<?php
	  if(isset($_SESSION['recUsername']))
  		echo "<a href='home' title='home'>Home</a>
		<a href='app' title='Application'>Application</a>
		<a href=\"logout\" title=\"logout\" id=\"logout\">Logout</a>";
	?>
  </nav>
  <section><!-- TemplateBeginEditable name="section" -->
  	
  <!-- TemplateEndEditable --></section>
 	<?php
  	//if(isset($_SESSION['recUsername']))
   		echo "<footer>@ blkCaphax</footer>";
	?>
</div>

<div id="lock-display">
	
</div>
<div id="wait-box" class='animate'>
	<img src="wait.gif" width="51" height="52" /><br>
	<div>
		<span></span><br>
		<p></p>
		<button>OK</button>
	</div>
</div>


</body>
</html>