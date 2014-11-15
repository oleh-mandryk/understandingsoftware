<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
    <meta name="description" content="<?=$main_info['description'];?>"/>
    <meta name="keywords" content="<?=$main_info['keywords'];?>"/>
    
    <title><?=$main_info['title'];?></title>   
    <link href="<?=base_url();?>img/icon.ico" rel="shortcut icon" media="screen" />
    
    <link href="<?=base_url();?>styles/main.css" rel="stylesheet" media="screen" type="text/css" />
    <link href="<?=base_url();?>styles/fancybox.css" rel="stylesheet" media="screen" type="text/css" />
    
    <script type="text/javascript" src="<?=base_url();?>js/jorphus.js"></script>
    <script type="text/javascript" src="<?=base_url();?>js/jquery-1.3.2.min.js"></script>
	
    <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="http://userapi.com/js/api/openapi.js?45"></script>

<script type="text/javascript">
  VK.init({apiId: API_ID, onlyWidgets: true});
</script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/uk_UA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



          
    <?=smiley_js();?>
</head>
<body>
<div id="fb-root"></div>
<a name="top"></a>
<div id="outer">