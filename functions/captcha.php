<?
include "shead.php";
function  create_image(){
        $im = @imagecreate(120, 35) or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, 226, 226, 223);   // grey
       
        $red = imagecolorallocate($im, 255, 0, 0);                  // red
        $blue = imagecolorallocate($im, 0, 0, 255);                 // blue

		$textcolor = imagecolorallocate($im, 83, 83, 83);
		$dotcolor = imagecolorallocate($im, 155, 155, 155);
		$str = "";
		$fullstr = "";
		$font = 'functions/Vinyl_George.ttf';
    	for ($i = 0; $i <= 5; $i++) {
        // this numbers refer to numbers of the ascii table (small-caps)
        	if(rand(1,2) == 1)
        	$str = chr(rand(97, 122));
			else
			$str = chr(rand(65, 90));
			$pos = (($i+1)*13);
        	imagettftext($im, 20, 0, $pos, rand(20,30), $textcolor, $font, $str);
			$fullstr .= $str;
			imageline ($im,   rand(0,120),  rand(0,120), rand(0,200), rand(0,200), $textcolor);
    	}
		for ($i = 0; $i <= 600; $i++) {
		imagesetpixel ( $im , rand(0,120) , rand(0,35) , $dotcolor );
		
		}
		unset($_SESSION['rand_code']);
		$_SESSION['rand_code'] = $fullstr;


       
        imagepng($im,"capthca.png");
        imagedestroy($im);
}
?>