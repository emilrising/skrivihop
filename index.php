<?php
include "i/head.php";
include "i/header.php";

require_once "classes/post.php";
require_once "classes/sitetext.php";
?>
	<div class="biglogo">

		<img src="images/logobigbeta.png" alt="Skrivihop.net - Skriv tillsammans!">

	</div>

<? 
if (!$currentUser)
/*
 * TODO: Lägga alla openID proiders i en variabel och loopa ut dem.
 * 		Fixa <noscript> taggen.
 */
{
?>
    <form name="login" class="box login" action="" method="post">
		<div class="arrowup">
			<!-- -->
		</div>
		<h2> Bli medlem/ Logga in. </h2> 
		
		  <div><ul class="providers"> 
  <li class="openid" title="OpenID"><img src="images/openid.png" alt="icon" /> 
  <span><strong>http://{your-openid-url}</strong></span></li> 
  <li class="direct" title="Google"> 
		<img src="images/google.png" alt="icon" /><span>https://www.google.com/accounts/o8/id</span></li> 
  <li class="direct" title="Yahoo"> 
		<img src="images/yahoo.png" alt="icon" /><span>http://yahoo.com/</span></li> 
  <li class="username" title="AOL screen name"> 
		<img src="images/aol.png" alt="icon" /><span>http://openid.aol.com/<strong>username</strong></span></li> 
  <li class="username" title="MyOpenID användarnamn"> 
		<img src="images/myopenid.png" alt="icon" /><span>http://<strong>username</strong>.myopenid.com/</span></li> 
  <li class="username" title="Flickr användarnamn"> 
		<img src="images/flickr.png" alt="icon" /><span>http://flickr.com/<strong>username</strong>/</span></li> 
  <li class="username" title="Technorati användarnamn"> 
		<img src="images/technorati.png" alt="icon" /><span>http://technorati.com/people/technorati/<strong>username</strong>/</span></li> 
  <li class="username" title="Wordpress blog namn"> 
		<img src="images/wordpress.png" alt="icon" /><span>http://<strong>username</strong>.wordpress.com</span></li> 
  <li class="username" title="Blogger blog namn"> 
		<img src="images/blogger.png" alt="icon" /><span>http://<strong>username</strong>.blogspot.com/</span></li> 
  <li class="username" title="LiveJournal blog namn"> 
		<img src="images/livejournal.png" alt="icon" /><span>http://<strong>username</strong>.livejournal.com</span></li> 
  <li class="username" title="ClaimID användanamn"> 
		<img src="images/claimid.png" alt="icon" /><span>http://claimid.com/<strong>username</strong></span></li> 
  <li class="username" title="Vidoop användarnamn"> 
		<img src="images/vidoop.png" alt="icon" /><span>http://<strong>username</strong>.myvidoop.com/</span></li> 
  <li class="username" title="Verisign användarnamn"> 
		<img src="images/verisign.png" alt="icon" /><span>http://<strong>username</strong>.pip.verisignlabs.com/</span></li> 
  </ul></div> 
  <fieldset> 
  <label for="openid_username">Ditt <span>Provider user name</span></label><br> 
  <div><span></span><input type="text" name="openid_username" /><span></span> 

  </fieldset> 
  <fieldset> 
  <label for="openid_identifier">Ditt  <a class="openid_logo" href="http://openid.net">OpenID</a></label> 
  <div><input type="text" name="openid_identifier" /> 

  </fieldset> 

    	<input type="submit" name="submit" value="Logga in">
    	<div class="error"><?= $errorMessage ?></div>
    	<br style="clear:both;">
	</form>
	<script type="text/javascript">
		$(function() {
			$("form.login:eq(0)").openid();
		}); 
</script>
<?php } ?>
	<h1>Skriv tillsammans!</h1>

	<h2>Om Skrivihop</h2>

	<p>

		Skrivihop är en social författarsida där du skriver en berättelse tillsammans med andra.

	</p>

	<p>

		På engelska skulle man säga collaborative storytelling, på svenska skulle vi vilja kalla det gemensamt författande, eller socialt berättande i skrift. Berättarkonst är till sin natur socialt, många berättelser växer fram i samspel med andra, klassikt författande är det kanske inte i samma utsträckning. Skrivihop är den gemensamma styrkan i det sociala berättandet och berättandet i skrift.

	</p>

	<? $post = Post::latest(); ?>
	
	<div class="box">
		<div class="arrowup">
		</div>
		<h2>Senaste inlägg</h2>
		
		<p>"<i><?= $post->body ?></i>"</p>
					
		<p class="byuser">
			Av <?= $post->creator()->url() ?>,<br>
			från krönikan <?= $post->chronicle()->url() ?></a>
		</p>
		<br style="clear:both;">	
	</div>

	<p>

		Skrivihop är gratis och kommer alltid vara det, den finns på grund av vår kärlek till det skrivna språket och berättarkonsten. Det enda vi ber om är ditt engagemang, din fantasi och din historia.

	</p>
<?php

$index_texts = array('historia','copyright','howdoesitwork','rules','cookies','beta');

foreach($index_texts as $get_txt){

	$siteText = SiteText::getInstance($get_txt);

?>
	<h2 class="heading"><?=$siteText->heading?>

	<div class="dotlight">

		+

	</div></h2>

	<div class="more">
		<?=$siteText->text?>
	</div>
<?php
}

include "i/footer.php";
include "i/foot.php";
?>
