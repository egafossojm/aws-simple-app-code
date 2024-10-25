<?php
header('Content-Type: application/xslt+xml');

$currSiteId = $_SERVER['QUERY_STRING'];

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $localhostSwitch = ['ad' => 'www.advisor.ca', 'av' => 'www.avantages.ca', 'be' => 'www.benefitscanada.com', 'co' => 'www.conseiller.ca', 'fi' => 'www.finance-investissement.com', 'ie' => 'www.investmentexecutive.com'];
    $serverName = $localhostSwitch[substr($_SERVER['REQUEST_URI'], 1, 2)];
    $homeBaseURL = 'http://'.$_SERVER['SERVER_NAME'].substr($_SERVER['REQUEST_URI'], 0, 3).'/';
} else {
    $serverName = $_SERVER['SERVER_NAME'];
    $homeBaseURL = 'https://'.$_SERVER['SERVER_NAME'].'/';
}

switch ($currSiteId) {
    case '5':
        $LogoNews = 'https://www.advisor.ca/wp-content/themes/avatar-ad/assets/images/site-logo.png';
        $language = 'en';
        break;
    case '4':
        $LogoNews = 'https://www.advisor.ca/wp-content/themes/avatar-co/assets/images/site-logo.png';
        $language = 'fr';
        break;
    case '2':
        $LogoNews = 'https://www.advisor.ca/wp-content/themes/avatar-fi/assets/images/site-logo.png';
        $language = 'fr';
        break;
    case '3':
        $LogoNews = 'https://www.advisor.ca/wp-content/themes/avatar-ie/assets/images/site-logo.png';
        $language = 'en';
        break;
    case '6':
        $LogoNews = 'https://www.advisor.ca/wp-content/themes/avatar-av/assets/images/site-logo.png';
        $language = 'fr';
        break;
    case '7':
        $LogoNews = 'https://www.advisor.ca/wp-content/themes/avatar-be/assets/images/site-logo.png';
        $language = 'en';
        break;
    default:
        $currSiteId = 0;
        break;
}
?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE copyright [
  <!ELEMENT copyright (#PCDATA)>
  <!ENTITY copy   "&#169;">
]>
<xsl:stylesheet version="1.1" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" /> 
	
	 <xsl:variable name="title" select="/rss/channel/title"/>		
	<xsl:template match="/">
	
		<html>
			<head>
				<title>
					<xsl:value-of select="$title"/> <?php echo $language == 'fr' ? 'Flux XML' : 'XML Feed'?></title>
			<link rel="stylesheet" href="<?php echo $homeBaseURL?>wp-content/themes/avatar-tcm/assets/css/nolsol_xsl.css" type="text/css"/>
			
			</head>	
		<xsl:apply-templates select="rss/channel"/>		
		</html>
	</xsl:template>
	
		<xsl:template match="channel">
		<body>		
			<a href="{link}"><img src="<?php if (isset($LogoNews)) {
			    echo $LogoNews;
			}?>" width="163" alt="News logo" border="0" vspace="10" /></a><br />
			
		 	<div class="topbox">
			<div class="padtopbox">
			<h2><?php echo $language == 'fr' ? 'Quelle est cette page?' : 'What is this page?'; ?></h2>
			<p><?php echo $language == 'fr' ? 'C\'est un flux RSS du site Web ' : 'This is an RSS feed from the '; ?><xsl:value-of select="image/title" /><?php echo $language == 'fr' ? ' Les flux RSS vous permettent de rester au courant des dernières nouvelles et des fonctionnalités de ' : ' website. RSS feeds allow you to stay up to date with the latest news and features you want from '; ?> <xsl:value-of select="image/title" />.</p>
			<p><?php echo $language == 'fr' ? 'Pour vous y abonner, vous aurez besoin d\'un lecteur de nouvelles ou d\'un autre appareil similaire.' : 'To subscribe to it, you will need a News Reader or other similar device.'; ?> 
			</p>

			</div>
			</div>		
			
			<div class="banbox">
			<div class="padbanbox">			
			<div class="mvb">
			<div class="fltl"><span class="subhead"><?php echo $language == 'fr' ? 'Flux RSS pour :' : 'RSS Feed For:'?> </span></div><a href="#" class="item"><img height="16" hspace="5" vspace="0" border="0" width="16" alt="RSS News feeds" src="<?php echo $homeBaseURL?>wp-content/themes/avatar-tcm/assets/images/feed.gif" title="RSS News feeds" align="left" /><xsl:value-of select="$title"/></a><br clear="all" />
			 </div>
			 
			</div>
			</div>		
			
			<div class="mainbox">
				<div class="itembox">
					<div class="paditembox">
					<xsl:apply-templates select="item"/>
					</div>
				</div>	
			</div>	
			
		<div class="footerbox">
		<p class="copyright__text">&copy; 1998-<?php echo date('Y').' '; ?>
			<?php
			echo $language == 'fr' ? 'Tous droits réservés. Transcontinental Inc.' : 'Transcontinental Media Inc. All rights reserved.';
?>
		</p>
		</div>
				
		</body>
	</xsl:template>
		
	<xsl:template match="item">
	<div id="item">
	<ul>
			<li>
				<a href="{link}" class="item">
					<xsl:value-of disable-output-escaping="yes" select="title"/>
				</a><br/>			
				<div>
				<xsl:value-of disable-output-escaping="yes" select="description" />					
				</div>	
				</li>
		</ul>
	</div>		
	</xsl:template>
	
</xsl:stylesheet>