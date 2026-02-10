<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?php echo base_url();?>photos/icons/psas-SIMS.png">
	<title>About</title>
</head>
<style type="text/css">
	h6{
		text-align: justify;
	}
    .background{
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;  
        height: 100vh;
        image-rendering: optimizeSpeed;
        background-image: url("<?php echo base_url();?>photos/background/psa_background.png");
    }
    .top_parallax {
    	max-height: 30vh !important;
    	height: 30vh !important;
    }
    .mid_parallax {
    	max-height: 75vh !important;
    	height: 75vh !important;
    }
    .bot_parallax {
    	max-height: 30vh!important;
    	height: 30vh!important;
    }
    .top_section {
    	max-height: 70vh !important;
    	height: 70vh !important;
    }
    .bot_section {
    	max-height: 70vh !important;
    	height: 70vh !important;
    }
    blockquote {
    	font-size: 1.8vh !important;
    }
    h4 {
    	font-size: 3vh !important;
    }
    h5 {
    	font-size: 2vh !important;
    }
</style>
<body>
	<?php include 'notifications.php';?>
	<div class="parallax-container top_parallax">
      <div class="parallax"><img src="<?php echo base_url();?>photos/background/no_logo.png"></div>
    </div>
    <div class="section brown darken-4 white-text text-lighten-2 top_section valign-wrapper flow-text">
    	<div class="row">
	        <h4 class="header center-align">About</h4>
	        <h4 class=" center-align">
				Philippine Statistics Authority (Samar) - Supplies Inventory Management System
			</h4>
	        <div class="col">
				<div class="col s8 offset-s2 ">
					<blockquote>
						&emsp;&emsp;We were in search of a near-perfect and precise system. Our office, through our new ISA I/COSW, developed a more accurate system for monitoring our supplies. This system can automatically generate the necessary reports required by the Commission on Audit (COA), such as the:
					</blockquote>
				</div>
			</div>
    		<div class="col s4 offset-s4">
				<blockquote class="center-align">
					<ol>
						<li>
							Report of Supplies and Materials Issued (RSMI), 
						</li>
						<br>
						<li>
							Supplies Ledger Card (for accounting), and the 
						</li>
						<br>
						<li>
							Report on the Physical Count of Inventories (RPCI). 
						</li>
					</ol>
				</blockquote>
			</div>
			<div class="col s8 offset-s2">
				<blockquote class="">
					&emsp;&emsp;PSAS-SiMS, short for PSA Samar - Supplies Inventory Management System, is an innovative solution designed to revolutionize supply management. With its user-friendly interface and precise tracking capabilities, PSAS-SiMS ensures efficient and reliable management of supplies. It's particularly beneficial in monitoring remaining supplies and generating zero-error reports. As we continue to enhance its features, we're confident that PSAS-SiMS will transform the way we handle supplies management at PSA Samar.
				</blockquote>
			</div>
			<br>					
		</div>
    </div>
    <div class="parallax-container mid_parallax">
      <div class="parallax"><img src="<?php echo base_url();?>photos/background/psa_background.png"></div>
    </div>
    <div class="section blue-grey darken-2 white-text text-lighten-2 bot_section valign-wrapper">
		<div class="row">
			<div class="col center-align">
				<h5>
					Contact the Developer
				</h5>
				<h4>
					Renzo Ferreras Advincula
				</h4>
				<img src="<?php echo base_url();?>photos/contact_us/mando.png" class="circle responsive-img small">
				<h5 class="center-align">
					Renzo's <a class="blue-text text-lighten-3" href="https://www.facebook.com/renzo.advincula.7">Facebook</a>
				</h5>
				<h5 class="red-text text-accent-2">
					advincularenzo@gmail.com
				</h5>
			</div>
		</div>
	</div>
	<div class="parallax-container bot_parallax">
      <div class="parallax"><img src="<?php echo base_url();?>photos/background/no_logo.png"></div>
    </div>
</body>
<script type="text/javascript">
	$('.parallax').parallax();
</script>
</html>