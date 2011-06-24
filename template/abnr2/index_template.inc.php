<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    <!--
    Created by Artisteer v2.5.0.31067
    Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
    -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php echo $metadata; ?>
    <title><?php echo $page_title; ?></title>

    <link rel="stylesheet" href="template/core.style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="template/abnr2/style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/updater.js"></script>
	<script type="text/javascript" src="js/gui.js"></script>
    <script type="text/javascript" src="template/abnr2/script.js"></script>
</head>
<body>
<div id="art-main">
        <div class="art-sheet">
            <div class="art-sheet-tl"></div>
            <div class="art-sheet-tr"></div>
            <div class="art-sheet-bl"></div>
            <div class="art-sheet-br"></div>
            <div class="art-sheet-tc"></div>
            <div class="art-sheet-bc"></div>
            <div class="art-sheet-cl"></div>
            <div class="art-sheet-cr"></div>
            <div class="art-sheet-cc"></div>
            <div class="art-sheet-body">
                <div class="art-header">
                    <div class="art-header-jpeg"></div>
                    <div class="art-logo">
                        <h1 id="name-text" class="art-logo-name"><a href="index.php"><?php echo $sysconf['library_name']; ?></a></h1>
                        <div id="slogan-text" class="art-logo-text"><?php echo $sysconf['library_subname']; ?></div>
                    </div>
                </div>
                <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">
                		<li>
                			<a class="active menu" href="index.php"><span class="l"></span><span class="r"></span><span class="t"><?php echo __('Home'); ?></span></a>
                		</li>
                		<li>
                			<a href="index.php?p=kh&keywords=khtype%3D&search=Search"><span class="l"></span><span class="r"></span><span class="t"><?php echo __('KH Collection'); ?></span></a>
                			<ul>
                				<li><a href="index.php?p=kh&keywords=khtype%3Dregulation&search=Search"><?php echo __('Regulation'); ?></a></li>
                				<li><a href="index.php?p=kh&keywords=khtype%3Dmemo&search=Search">Memo/Advice/Opinions</a></li>
                				<li><a href="index.php?p=kh&keywords=khtype%3Dinstrument&search=Search">Instruments</a></li>
                			</ul>
                		</li>
                		<li>
                			<a class="menu" href="index.php?p=libinfo"><span class="l"></span><span class="r"></span><span class="t"><?php echo __('Library Information'); ?></span></a>
                		</li>
                		<li>
                			<a class="menu" href="index.php?p=help"><span class="l"></span><span class="r"></span><span class="t"><?php echo __('Help on Search'); ?></span></a>
                		</li>
                		<li>
                			<a class="menu" href="index.php?p=member"><span class="l"></span><span class="r"></span><span class="t"><?php echo __('Member Area'); ?></span></a>
                		</li>
                		<li>
                			<a class="menu" href="index.php?p=login"><span class="l"></span><span class="r"></span><span class="t"><?php echo __('Librarian LOGIN'); ?></span></a>
                		</li>
                	</ul>
                </div>
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-sidebar1">
                            <div class="art-block">
                                <div class="art-block-tl"></div>
                                <div class="art-block-tr"></div>
                                <div class="art-block-bl"></div>
                                <div class="art-block-br"></div>
                                <div class="art-block-tc"></div>
                                <div class="art-block-bc"></div>
                                <div class="art-block-cl"></div>
                                <div class="art-block-cr"></div>
                                <div class="art-block-cc"></div>
                                <div class="art-block-body">
                                            <div class="art-blockheader">
                                                 <div class="t"><?php echo __('KH Collection'); ?></div>
                                            </div>
                                            <div class="art-blockcontent">
                                                <div class="art-blockcontent-body">
													<form name="simpleSearch" action="index.php" method="get">
													<input type="hidden" name="p" value="kh" />
													<input type="text" name="keywords" style="width: 99%;" /><br />
													<input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
													</form>
                                            		<div class="cleared"></div>
                                                </div>
                                            </div>
                            		<div class="cleared"></div>
                                </div>
                            </div>                        
                        
                            <div class="art-block">
                                <div class="art-block-tl"></div>
                                <div class="art-block-tr"></div>
                                <div class="art-block-bl"></div>
                                <div class="art-block-br"></div>
                                <div class="art-block-tc"></div>
                                <div class="art-block-bc"></div>
                                <div class="art-block-cl"></div>
                                <div class="art-block-cr"></div>
                                <div class="art-block-cc"></div>
                                <div class="art-block-body">
                                            <div class="art-blockheader">
                                                 <div class="t"><?php echo __('Book Search'); ?></div>
                                            </div>
                                            <div class="art-blockcontent">
                                                <div class="art-blockcontent-body">
													<form name="simpleSearch" action="index.php" method="get">
													<input type="text" name="keywords" style="width: 99%;" /><br />
													<input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
													</form>
                                            		<div class="cleared"></div>
                                                </div>
                                            </div>
                            		<div class="cleared"></div>
                                </div>
                            </div>                            
                            
                            <div class="art-block">
                                <div class="art-block-tl"></div>
                                <div class="art-block-tr"></div>
                                <div class="art-block-bl"></div>
                                <div class="art-block-br"></div>
                                <div class="art-block-tc"></div>
                                <div class="art-block-bc"></div>
                                <div class="art-block-cl"></div>
                                <div class="art-block-cr"></div>
                                <div class="art-block-cc"></div>
                                <div class="art-block-body">
                                            <div class="art-blockheader">
                                                 <div class="t"><?php echo __('Select Language'); ?></div>
                                            </div>
                                            <div class="art-blockcontent">
                                                <div class="art-blockcontent-body">
													<form name="langSelect" action="index.php" method="get">
													<select name="select_lang" style="width: 99%;" onchange="document.langSelect.submit();">
													<?php echo $language_select; ?>
													</select>
													</form>
                                            		<div class="cleared"></div>
                                                </div>
                                            </div>
                            		<div class="cleared"></div>
                                </div>
                            </div>
                            
                            <div class="art-block">
                                <div class="art-block-tl"></div>
                                <div class="art-block-tr"></div>
                                <div class="art-block-bl"></div>
                                <div class="art-block-br"></div>
                                <div class="art-block-tc"></div>
                                <div class="art-block-bc"></div>
                                <div class="art-block-cl"></div>
                                <div class="art-block-cr"></div>
                                <div class="art-block-cc"></div>
                                <div class="art-block-body">
                                            <div class="art-blockheader">
                                                 <div class="t"><?php echo __('Advanced Search'); ?></div>
                                            </div>
                                            <div class="art-blockcontent">
                                                <div class="art-blockcontent-body">
													<form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
													<?php echo __('Title'); ?> :
													<input type="text" name="title" class="ajaxInputField" /><br />
													<?php echo __('Author(s)'); ?> :
													<?php echo $advsearch_author; ?><br />
													<?php echo __('Subject(s)'); ?> :
													<?php echo $advsearch_topic; ?><br />
													<?php echo __('ISBN/ISSN'); ?> :
													<input type="text" name="isbn" /><br />
													<?php echo __('GMD'); ?> :
													<select name="gmd" />
													<?php echo $gmd_list; ?>
													</select>
													<?php echo __('Collection Type'); ?> :
													<select name="colltype" />
													<?php echo $colltype_list; ?>
													</select>
													<?php echo __('Location'); ?> :
													<select name="location" />
													<?php echo $location_list; ?>
													</select>
													<br />
													<input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
													<!-- <input type="button" value="More Options" onclick="" class="button marginTop" /> -->
													</form>
                                            		<div class="cleared"></div>
                                                </div>
                                            </div>
                            		<div class="cleared"></div>
                                </div>
                            </div>
                            <div class="art-block">
                                <div class="art-block-tl"></div>
                                <div class="art-block-tr"></div>
                                <div class="art-block-bl"></div>
                                <div class="art-block-br"></div>
                                <div class="art-block-tc"></div>
                                <div class="art-block-bc"></div>
                                <div class="art-block-cl"></div>
                                <div class="art-block-cr"></div>
                                <div class="art-block-cc"></div>
                                <div class="art-block-body">
                                            <div class="art-blockheader">
                                                 <div class="t">Contact Info</div>
                                            </div>
                                            <div class="art-blockcontent">
                                                <div class="art-blockcontent-body">
                                            <!-- block-content -->
                                                            <div>
                                                                  <img src="template/abnr2/images/contact.jpg" alt="an image" style="margin: 0 auto;display:block;width:95%" />
                                                            <br />
                                                            <b>ABNR</b><br />
                                                            Jakarta<br />
                                                            Email: <a href="mailto:info@company.com">info@company.com</a><br />
                                                            <br />
                                                            Phone: (021) 456-7890 <br />
                                                            Fax: (021) 456-7890
                                                            </div>
                                            <!-- /block-content -->
                                            
                                            		<div class="cleared"></div>
                                                </div>
                                            </div>
                            		<div class="cleared"></div>
                                </div>
                            </div>
                        </div>
                        <div class="art-layout-cell art-content">
                            <div class="art-post">
                                <div class="art-post-body">
                            <div class="art-post-inner art-article">
                                            <div class="art-postcontent">
												<blockquote>
                                                <?php echo $header_info; ?>
                                                </blockquote>
                                                <div class="cleared"></div>
                                                <div id="infoBox"><?php echo $info; ?></div>
                                                <div class="cleared"></div>
                                                <p>&nbsp;</p>
                                                <?php echo $main_content; ?>
                                            </div>
                                            <div class="cleared"></div>
                            </div>
                            
                            		<div class="cleared"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cleared"></div><div class="art-footer">
                    <div class="art-footer-t"></div>
                    <div class="art-footer-l"></div>
                    <div class="art-footer-b"></div>
                    <div class="art-footer-r"></div>
                    <div class="art-footer-body">
                         <a href="#" class="art-rss-tag-icon" title="RSS"></a>
                        <div class="art-footer-text">
                            Copyright &copy; 2010 ABNR. All Rights Reserved.</p>
                        </div>
                		<div class="cleared"></div>
                    </div>
                </div>
        		<div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>
        <p class="art-page-footer"></p>
    </div>
    
</body>
</html>
