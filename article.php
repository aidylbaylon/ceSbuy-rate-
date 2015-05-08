 <?php 
require_once 'core/connect/database.php';
 
$article = null;

if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];

		$article = $db->query("SELECT * FROM posts WHERE post_id = $id")->fetch(PDO::FETCH_ASSOC);
	}	
?>

<html>
<head>
	<meta charset="utf-8">
	<title>Article</title>
</head>
<body>
	<?php if($article): ?>
		<div class-"article">
				This is article "<?php echo $article['name']; ?>".
			<div class="article-rating">Rating x/5</div>
			<div class="article-rate">
				Rate this article:
				<?php foreach(range(1,5) as $rating): ?>
					<a href="rate.php?article=<?php echo $article['post_id']; ?>&rating=<?php echo $rating; ?>"><?php echo $rating?></a>
				<?php endforeach;?>
			</div>
		</div>

	<?php endif;?> 

</body>
</html>