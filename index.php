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
{
?>
    <form name="login" class="box login" action="" method="post">
		<div class="arrowup">
			<!-- -->
		</div>
		<h2> Bli medlem/ Logga in. </h2> 
    	<p><a onclick="document.forms['login'].openid_identifier.value='https://www.google.com/accounts/o8/id'">Google-konto</a></p>
    	<label for="openid_identifier">OpenID URL</label><input type="text" name="openid_identifier" />
    	<input type="submit" name="submit" value="Logga in">
    	<p><i><?= $errorMessage ?></i></p>
	</form>
<?php
}
?>
	<h1>Skriv tillsammans!</h1>



	<h2>Om Skrivihop</h2>

	<p>

		Skrivihop är en social författarsida där du skriver en berättelse tillsammans med andra.

	</p>

	<p>

		På engelska skulle man säga collaborative storytelling, på svenska skulle vi vilja kalla det gemensamt författande, eller socialt berättande i skrift. Berättarkonst är till sin natur socialt, många berättelser växer fram i samspel med andra, klassikt författande är det kanske inte i samma utsträckning. Skrivihop är den gemensamma styrkan i det sociala berättandet och berättandet i skrift.

	</p>

	<? 
	$post = Post::latest();
	?>
	
	<div class="box">
		<div class="arrowup">
		</div>
		<h2>Senaste inlägg</h2>
		
		<p>"<i><?= $post->body ?></i>"</p>
					
		<p class="byuser">
			Av <?= $post->user()->url() ?>,<br>
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
