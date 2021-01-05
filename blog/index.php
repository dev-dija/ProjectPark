<?php include("../config.php");
if(isset($_GET['page']) && $_GET['page']<1 || isset($_GET['page']) && ! is_numeric($_GET['page'])) header("location: index.php");
if(isset($_GET['id']) && $_GET['id']<1 || isset($_GET['id']) && ! is_numeric($_GET['id'])) header("location: index.php");

if(isset($_GET['la']) && isset($_GET['id'])){
	$row = $conn->query("SELECT * FROM article WHERE id_art={$_GET['id']}")->fetch_array();
	$who_likes = explode(',', $row['who_like_art']);
	if(! in_array($_SESSION['user'][0], $who_likes)){
		$like = $row['like_art']+1;
		if(count($who_likes)==0) $who_likes[0] = $_SESSION['user'][0];
		else $who_likes[0] = $_SESSION['user'][0];
		$who_likes = implode(',', $who_likes);
		$res = $conn->query("UPDATE article SET like_art=$like,who_like_art='$who_likes' WHERE id_art={$_GET['id']}");
	}
}
if(isset($_GET['ula']) && isset($_GET['id'])){
	$row = $conn->query("SELECT * FROM article WHERE id_art={$_GET['id']}")->fetch_array();
	$who_likes = explode(',', $row['who_like_art']);
	if(in_array($_SESSION['user'][0], $who_likes)){
		$like = $row['like_art']-1;
		for($i=0;$i<count($who_likes);$i++) if($who_likes[$i]==$_SESSION['user'][0]) unset($who_likes[$i]);
		$who_likes = implode(',', $who_likes);
		$res = $conn->query("UPDATE article SET like_art=$like,who_like_art='$who_likes' WHERE id_art={$_GET['id']}");
	}
}

if(isset($_SESSION['user']) && isset($_GET['id'])){
	if(isset($_POST['docomment'])){
		$mycomment = $_POST['mycomment'];
		if(strlen($mycomment)<=512){
			if($_SESSION['user'][1]==0) $cmpt = "freelancer";
			else $cmpt = "entreprise";
			$res = $conn->query("INSERT INTO comment VALUES('', '$mycomment', CURDATE(), CURTIME(), '{$_GET['id']}', '{$_SESSION['user'][0]}', '$cmpt')");
		}
	}
}

if(isset($_GET['id']) && isset($_GET['deletecmt'])){
	$res = $conn->query("DELETE FROM comment WHERE id_cmt={$_GET['deletecmt']} AND id_art={$_GET['id']}");
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>ProjectPark - Blog</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1><a href="index.php"><font color="#ccc">Project</font><font color="#5a88ca">Park</font></a></h1>
						<nav class="links">
							<ul>
								<li><a href="index.php">Accueil</a></li>
								<li><a href="../index.php">Site</a></li>
							</ul>
						</nav>
						<nav class="main">
							<ul>
								<li class="menu">
									<a class="fa-bars" href="#menu">Menu</a>
								</li>
							</ul>
						</nav>
					</header>

				<!-- Menu -->
					<section id="menu">
						<!-- Links -->
							<section>
								<ul class="links">
									<li>
										<a href="index.php">
											<h3>Accueil</h3>
											<p>Page d'accueil blog</p>
										</a>
									</li>
								</ul>
							</section>

						<!-- Actions -->
							<section>
								<ul class="actions vertical">
									<li><a href="../index.php" class="button big fit">Site</a></li>
								</ul>
							</section>

					</section>

				<!-- Main -->
					<div id="main">
					<?php
					if(! isset($_GET['id'])){
						if(isset($_GET['page'])) $current=$_GET['page'];
						else $current=1;
						$nbarticles = $conn->query("SELECT count(*) nb FROM article")->fetch_array()['nb'];
						$article_per_page=3;
						$from = ($current-1)*$article_per_page;
						$to = $from+$article_per_page;
						$res = $conn->query("SELECT *,DATE_FORMAT(date_art, '%m/%d/%Y') d,DATE_FORMAT(heur_art, '%r') h FROM article LIMIT $from,$to");
						while($row = $res->fetch_array()){$content=$row['content_art']; 
						if(strlen($content)>350){$content=substr($content, 0, 350)."...";}
						$nbcomments = $conn->query("SELECT count(*) nb FROM comment WHERE id_art={$row['id_art']}")->fetch_array()['nb'];
					?>
						<!-- Post -->
							<article class="post">
								<header>
									<div class="title">
										<h2><a href="index.php?id=<?php echo $row['id_art'];?>"><?php echo $row['titre_art'];?></a></h2>
									</div>
									<div class="meta">
										<time class="published"><?php echo dateToString($row['d']);?></time>
										<a href="../index.php" class="author"><span class="name">ProjectPark</span><img src="images/avatar.jpg"/></a>
									</div>
								</header>
								<a href="index.php?id=<?php echo $row['id_art'];?>" class="image featured"><img src="<?php echo $row['pic_art'];?>" alt="" /></a>
								<p><?php echo $content;?></p>
								<footer>
									<ul class="actions">
										<li><a href="index.php?id=<?php echo $row['id_art'];?>" class="button big">Lire la suite</a></li>
									</ul>
									<ul class="stats">
										<li><a class="icon fa-heart"><?php echo $row['like_art'];?></a></li>
										<li><a class="icon fa-comment"><?php echo $nbcomments;?></a></li>
									</ul>
								</footer>
							</article>
					<?php }
					}else{
						$art = $conn->query("SELECT *,DATE_FORMAT(date_art, '%m/%d/%Y') d,DATE_FORMAT(heur_art, '%r') h FROM article WHERE id_art={$_GET['id']}")->fetch_array();
						$content=$art['content_art'];
						$nbcomments = $conn->query("SELECT count(*) nb FROM comment WHERE id_art={$art['id_art']}")->fetch_array()['nb'];
						?>
							<article class="post">
								<header>
									<div class="title">
										<h2><a><?php echo $art['titre_art'];?></a></h2>
									</div>
									<div class="meta">
										<time class="published"><?php echo dateToString($art['d']);?></time>
										<a href="../index.php" class="author"><span class="name">ProjectPark</span><img src="../images/logo.png"/></a>
									</div>
								</header>
								<a class="image left" id="imgA" style="cursor: pointer;"><img src="<?php echo $art['pic_art'];?>"/></a>
								<p><?php echo $content;?></p>
								<footer>
									<ul class="actions">
									<?php if(isset($_SESSION['user'])){ 
										$who_likes = explode(',', $art['who_like_art']);
										if(! in_array($_SESSION['user'][0], $who_likes)) echo "<li><a href='index.php?id={$_GET['id']}&la=true'>j'aime</a></li>";
										else echo "<li><a href='index.php?id={$_GET['id']}&ula=true'>je n'aime plus</a></li>";
										echo "<li><a href='#cmt' style='cursor:pointer' id='showcommenter'>commentaires</a></li>";
										}
									?>
									</ul>
									<ul class="stats">
										<li><a class="icon fa-heart"><?php echo $art['like_art'];?></a></li>
										<li><a class="icon fa-comment"><?php echo $nbcomments;?></a></li>
									</ul>
								</footer>
								<div class="commenter" style="display: none
								;"><hr>
								<?php 

									$res = $conn->query("SELECT *,DATE_FORMAT(date_cmt, '%m/%d/%Y') d,DATE_FORMAT(heur_cmt, '%r') h FROM comment WHERE id_art={$_GET['id']} ORDER BY id_cmt DESC");
									while($row = $res->fetch_array()){
										$acc = $row['acc_art'];
										$idacc = $row['id'];
										$res2 = $conn->query("SELECT * FROM $acc WHERE id=$idacc")->fetch_array();
										echo "
										<div class='comment-item'>
											<img src='../{$res2['avatar']}' class='image img-circle' align='left' title='{$res2['prenom']} {$res2['nom']}'>
											<div class='comment-content'>
												{$row['content_cmt']}
											</div>
											<div class='comment-time'>";
											if($row['id']==$_SESSION['user'][0]) echo "<a href='index.php?id={$_GET['id']}&deletecmt={$row['id_cmt']}' title='supprimer le commentaire'><i class='fa fa-trash'></i></a>";
												echo "<a title='".(time_passed($row['d'].' '.$row['h'], 'il y a'))."'<i class='fa fa-clock'></i> {$row['d']}<br>{$row['h']}</a>
											</div>
										</div>";
									}
								?><hr>
								<div class="commenter-cmt">
									<div class="form-control"  style="clear:both">
										<form method="POST" id="registration-form">
										<h6>moins de <font color=red><b><span id="pres-max-length">512</span></b></font> characters</h6>
											<textarea  id="presentation" name="mycomment" id="cmt"></textarea>
											<button name="docomment" type="submit" class="pull-right" style="margin-top: 5px;">COMMENTER</button><br><br>
										</form>
									</div>
								</div>
								</div>
							</article>
						<?php }?>
						<!-- Pagination -->
						<?php if(!isset($_GET['id'])){?>
							<ul class="actions pagination">
								<li><a href="index.php?page=<?php echo $current-1;?>" class="<?php if($current<=1) echo 'disabled';?> button big previous">Previous Page</a></li>
								<?php for($i=1;$i<=ceil($nbarticles/$article_per_page);$i++) echo "<li><a href='index.php?page=$i' class='button big'>$i</a></li>";?>
								<li><a href="index.php?page=<?php echo $current+1;?>" class="<?php if($current>=ceil($nbarticles/$article_per_page)) echo 'disabled';?> button big next">Next Page</a></li>
							</ul>
						<?php }?>
					</div>

				<!-- Sidebar -->
					<section id="sidebar">

						<!-- Intro -->
							<section id="intro">
								<a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>
								<header>
									<h2>Project Park</h2>
									<p>Le site de freelancing et de stages</a></p>
								</header>
							</section>

						<!-- Mini Posts -->
							<section>
								<div class="mini-posts">
								<?php
								$res = $conn->query("SELECT *,DATE_FORMAT(date_art, '%m/%d/%Y') d FROM article ORDER BY id_art DESC LIMIT 4");
								while($row = $res->fetch_array()){
										echo "<article class='mini-post'>
											<header>
												<h3><a href='index.php?id={$row['id_art']}'>{$row['titre_art']}</a></h3>
												<time class='published'>".(dateToString($_GET['d']))."</time>
											</header>
											<a href='index.php?id={$row['id_art']}' class='image'><img src='{$row['pic_art']}'/></a>
										</article>";
								}
							?>
								</div>
							</section>

						<!-- Posts List -->
							<section>
								<ul class="posts">
								<?php
									$res = $conn->query("SELECT *,DATE_FORMAT(date_art, '%m/%d/%Y') d FROM article ORDER BY RAND() LIMIT 5");
									while($row = $res->fetch_array()){
										echo "<li>
											<article>
												<header>
													<h3><a href='index.php?id={$row['id_art']}'>{$row['titre_art']}</a></h3>
													<time class='published'>".(dateToString($_GET['d']))."</time>
												</header>
												<a href='index.php?id={$row['id_art']}' class='image'><img src='{$row['pic_art']}'/></a>
											</article>
										</li>";
									}
								?>
								</ul>
							</section>

						<!-- About -->
							<section class="blurb">
								<h2>About</h2>
								<p><b>Chercher Projects Au Maroc</b><br>
								Recrutez des Freelancers qualifiés, à distance ou sur place, dans tout le Maroc. Trouvez des talents
								en Développement Web/Mobile, Infographie, Marketing, Finance, Rédaction, Traduction...</p>
								<ul class="actions">
									<li><a href="../index.php" class="button">Site</a></li>
								</ul>
							</section>

						<!-- Footer -->
							<section id="footer">
								<ul class="icons">
									<li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="fa-rss"><span class="label">RSS</span></a></li>
									<li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
								</ul>
								<p class="copyright">2017&copy; ProjectPart, All rights reserved</p>
							</section>

					</section>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script type="text/javascript">
				$(document).ready(function(){
					$("#imgA").click(function(){
						if($(this).hasClass("featured")){
							$(this).removeClass("featured");
							$(this).addClass("left");
						}else{
							$(this).addClass("featured");
							$(this).removeClass("left");
						}
					})
					//////////:: commenting
					$("#showcommenter").click(function(){
						$(".commenter").toggle("medium");
					})
					$('[data-toggle="tooltip"]').tooltip();
				})
			</script>

	</body>
</html>