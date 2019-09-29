<?php

/*
 Plugin Name: Private Safelink
 Plugin URI: https://github.com/nimegami01/private_safelink/
 Description: Safelink Private
 Version: 3.0
 Author: Sativa Wahyu Priyanto
 Author URI: nimegami.com
 */

 class private_safelink{
 	public function redirect_awal(){
 		if($_GET['ref']){
 			?>
 			<style type="text/css">
 				input {display: none;}
 			</style>
 			<form method="POST" action="<?php echo home_url('/'); ?>">
 				<input type="hidden" name="data" value="<?php echo base64_encode($_GET['ref']); ?>">
				<input type="submit" name="submit" value="submit" id="submit">
 			</form>
 			<script type="text/javascript">
 				var button = document.getElementById("submit");
 					button.click();
 			</script>
 			<?php
 			exit();
 		}else if($_GET['reff']){
 			?>
 			<style type="text/css">
 				input {display: none;}
 			</style>
 			<form method="POST" action="<?php echo home_url('/'); ?>">
 				<input type="hidden" name="data" value="<?php echo $_GET['reff']; ?>">
 				<input type="submit" name="submit" value="submit" id="submit">
 			</form>
 			<script type="text/javascript">
 					var button = document.getElementById("submit");
 					button.click();
 			</script>
 			<?php
 		}
 	}

 	public function home_page(){
 		if($_POST['data']){	
 			function home_pg($atts){
				$get_rand = new wp_query(array('post_type' => 'POST', 'orderby' => 'rand', 'posts_per_page' => 1, 'ignore_sticky_posts' => true));
 			while ( $get_rand->have_posts() ) : $get_rand->the_post();
				$rand_link = get_the_permalink();
			endwhile;
 				$data = "
				<div class='clear'></div>
 				<form action='".$rand_link."' method='POST'>
 				<input type='hidden' name='data' value='".$_POST['data']."'>
 				<center><button class='prosesss'>GENERATE LINK</button></center>
 				</form>
				<div class='clear'></div>
 				";
 				return $data;
 			}
 			add_shortcode('rumah', 'home_pg');
 		}else{
 			function home_pg($atts){
 				$data = "<div class='clear'></div><div id='notif'>Maaf tidak dapat memproses link. Jika sebelumnya anda merefresh halaman ini, proses generate link akan error. Oleh karena itu, silahkan kembali ke Nimegami, dan klik link download lagi. Terimakasih.</div>";
 				return $data;
 			}
 			add_shortcode('rumah', 'home_pg');
 		}
 	}

 	public function post_page(){
 		if($_POST['data']){
 			function please_wait($atts){
 				$pw = "<div class='clear'></div><center><a href='#generate' id='gen_link'>CLICK 2X TO GENERATE LINK</a></center>";
 				$data = "<div class='clear'></div><center><div id='tunggu'>...</div></center>";
 				return $pw.$data;
 			}
 			add_shortcode('tunggu', 'please_wait');

 			function link_asli($atts){
 				$la = "<div class='clear'></div><center><div id='cloud'>GO TO LINK</div></center>";
 				$tung = "<div class='clear'></div><center><div id='tunggu_link_asli'>...</div></center>";
 				$data = "<div class='clear'></div><div id='generate'></div>";
 				return $data.$tung.$la;
 			}
 			add_shortcode('menuju', 'link_asli');
 		}else{
 			function please_wait($atts){
 				$data = "<div class='clear'></div><div id='notif'>Maaf tidak dapat memproses link. Jika sebelumnya anda merefresh halaman ini, proses generate link akan error. Oleh karena itu, silahkan kembali ke Nimegami, dan klik link download lagi. Terimakasih.</div>";
 				return $data;
 			}
 			add_shortcode('tunggu', 'please_wait');

 			function link_asli($atts){
 				$data = "<div class='clear'></div><div id='notif'>Maaf tidak dapat memproses link. Jika sebelumnya anda merefresh halaman ini, proses generate link akan error. Oleh karena itu, silahkan kembali ke Nimegami, dan klik link download lagi. Terimakasih.</div>";
 				return $data;
 			}
 			add_shortcode('menuju', 'link_asli');
 		}
 	}

 	// WP HEAD
 	public function add_aditional(){
 		function to_head(){
 			?>
 			<script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
 			<style type="text/css">
				.clear {clear:both;}
 				#gen_link,#cloud,#tunggu_link_asli {display: none;}
 				#notif {padding: 10px;border: 1px solid #6BBC54;background: #8DCD7B;color: #fff;border-radius: 3px;line-height: 22px;font-size: 14px;margin: 10px;}
 				#tunggu,#gen_link,#cloud,#tunggu_link_asli {padding: 7px 10px;background: #80D268;color: #fff;border-radius: 3px;margin: 10px auto;}
 				#gen_link {background: #F1A155;}
 				#cloud {background: #59BCDA;}
 				#tunggu {display: inline-block;}
 				#cloud {cursor: pointer;}
				.prosesss {padding:12px 15px;border-radius:3px;background:#55B0CC;color:#fff;color:#fff;border:none;margin:10px;cursor:pointer;}
 			</style>
 			<?php
 		}
 		add_action('wp_head', 'to_head');
 		function to_footer(){
 			if($_POST['data']){
 			?>
 			<script type="text/javascript">
 				if ( window.history.replaceState ) {
			        window.history.replaceState( null, null, window.location.href );
			    }
 				$(document).ready(function(){
 					var interval = 5;
 					var interval_tunggu = setInterval(function(){
 						$('#tunggu').html('Please Wait.. '+interval--);
 						if(interval == 0){
 							clearInterval(interval_tunggu);
 							$('#tunggu').fadeOut();
 							$('#gen_link').fadeIn().css({'display':'inline-block'});
 						}
 					}, 1000);
 					$('#gen_link').click(function(){
 						$('#tunggu_link_asli').fadeIn().css({'display':'inline-block'});
 						var interval_link_asli = 3;
 						var interval_link_asli2 = setInterval(function(){
 							$('#tunggu_link_asli').html('Please Wait.. '+interval_link_asli--);
 							if(interval_link_asli == 0){
 								clearInterval(interval_link_asli2);
 								$('#tunggu_link_asli').fadeOut();
 								$('#cloud').fadeIn().css({'display':'inline-block'});
 							}
 						}, 1000)
 					})

	 					$('#cloud').click(function(){
	 						window.open('<?php echo base64_decode($_POST['data']); ?>');
	 					})

 					})
 			</script>
 			<?php
 			}
 		}
 		add_action('wp_footer', 'to_footer');
 	}


 	public function __construct(){
 		add_action('init', array (&$this,'redirect_awal'));
 		add_action('init', array (&$this,'home_page'));
 		add_action('init', array (&$this,'post_page'));
 		add_action('init', array (&$this,'add_aditional'));
 	}
 }
 $pv_safelink = new private_safelink();
