<?php
$page_title = "";
include_once("_h.php");
?>

<?php
$baseurl="videochat/";
$swfurl=$baseurl."2wvc.swf?room=".$roomname;
$bgcolor="#051e43";
?><style type="text/css">
<!--
#videochat_container
{
	height:700px;
	width:100%;
	z-index:0;
	text-align:center;
	background:#28213C;
}
-->
</style>

<?php
if ($fb_user||!$fb_only)
{
?>
<div id="videochat_container">
<object id="videowhisper_chat" width="1000" height="100%">
<param name="movie" value="<?=$swfurl?>" /><param name="bgcolor" value="<?=$bgcolor?>" /><param name="scale" value="noscale" /><param name="allowFullScreen" value="true" /><param name="allowscriptaccess" value="always" /> <param name="base" value="<?=$baseurl?>" /> <param name="wmode" value="transparent" /> <embed name="videowhisper_chat" width="100%" height="100%" scale="noscale" src="<?=$swfurl?>" bgcolor="<?=$bgcolor?>" base="<?=$baseurl?>" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="transparent"></embed>
</object>
<noscript>
<p align=center>VideoWhisper  <a href="http://www.videowhisper.com/?p=Chat+Roulette+Clone+Script"><strong>Video Chat Roulette Script</strong></a></p>
<p align="center"><strong>This content requires the Adobe Flash Player:
<a href="http://get.adobe.com/flashplayer/">Get Latest Flash</a></strong>!</p>
</noscript>
</div>

  <?php
}
else 
{
	?>
  <blockquote>
  <IMG SRC="videochat/templates/2wvc/logo.png">
    <p style="font-size: 24px; line-height: 25px;">
      <a href="<?php echo $loginUrl; ?>"><strong>Login with Facebook</strong></a> and get instant access to:
      
  <br />
      + free random webcam chat<br />
      + choose your chat partners: gender, location, webcam on
      <br />
      + high quality webcam snapshots<br />
      + detailed chat logs including snapshots<br />
      + just leave this in background: rings on encounter
      <br />
      + meet real people you can friend on Facebook
    </p>
    <p>Login is required for a better chat experience and abuse prevention.</p>
    Recent users<BR>
<?php
$rl=qs($sql="u.name, uf.pic_square, uf.profile_url from user u, user_facebook uf WHERE u.id=uf.user_id AND u.id > 1 ORDER BY u.id DESC LIMIT 0, 100");

if (!e($rl)) while ($ul = f($rl)) echo "<IMG SRC='" . $ul['pic_square'] . "' ALIGN='ABSMIDDLE'>";

//if (!e($rl)) while ($ul = f($rl)) echo "<A HREF='$ul[profile_url]' TARGET='_blank'><IMG SRC='$ul[pic_square]' ALIGN='ABSMIDDLE'></A> ";
?>
</blockquote>


<?php

}


include_once("_f.php");
?>
