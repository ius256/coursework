<?php
include('commentDB.php');

//setting username to show on profile
$nameOfUser = $_SESSION["usr_fullname"];

//setting photo/user's image to display on profile
$userPhoto = $_SESSION["usr_photo"];

//getting specific article id...
$id = $_GET['id'];

// if session is not set, then user redirects to login page...
if (!$nameOfUser){
	header("Location:login.php");
}
require('layout.php');
?>

			<section class = "news_list_container">
                <h2 id = "heading">ARTICLE</h2>
			</section>
			<div class = "article_cont">
		   <?php
		   		// selecting specific article data...
				$statemnt = $connection->prepare("SELECT * FROM `assignment1`.`article` WHERE id = '$id'");
				// executing the selected data...
				$statemnt->execute();

				// fetching the executed data...
				$results = $statemnt->fetch(PDO::FETCH_NUM);
			?>
						
				<div class = "evr_news">
					<!-- showing category -->
					<p style = "float: left;">Category:&nbsp;<?php echo $results[3]; ?></p>
					<!-- showing publisher name -->
					<p style = "float: right;">Published By:&nbsp;<?php echo $results[6]; ?></p>
				<div class = "atcDate">
					<!-- showing published date -->
					<label>Published On:&nbsp;</label><em><?php echo $results[4]; ?></em>
				</div>
				<!-- showing news title -->
					<div class = "news_ttl"><?php echo $results[1]; ?></div>
					<!-- showing news title (if available) else showing default placeholder image -->
					<div class = "news_image"><img src = "public/images/articles/
					<?php
					if ($results[5]){
					 echo $results[5]; 
					}
					else{
						//Image taken from: (Ref: https://www.forming.com/about-us/news)
						echo "placeholder.png";
					}
					?>"
					alt = "News Article Image">
					</div>
				<article class = "news_atcl">
					<!-- showing news content -->
				<?php echo $results[2]; ?>
				</article>
			</div>
			<!-- form for writing the comment done by user to database.. -->
			<form method = "POST" class = "comment_form">
				<!-- comment input field -->
				<label>Comment</label> <textarea name="commentText" placeholder = "Post a comment here..." rows="5" required></textarea>

				<!-- for news id -->
				<input type = "number" value = "<?php echo $id ?>" name = "news_id" style = "display: none;">
				<!-- submit button -->
				<input type = "submit" name = "post" value = "Post">
			</form>
		</div>
		<!-- comment showing (done by user) field -->
                <h3 style = "margin: 30px; font-size: 30px; font-weight: lighter;">Comments</h3>
		<div class = "all_comments">
		<?php
			// selecting all data from comment table
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`comment`");

				// executing the selected data...
                $statemnt->execute();

				// checking if data is available in comment table...
				if ($statemnt->rowCount() > 0){

					// fetching the executed data...
                while ($comResult = $statemnt->fetch(PDO::FETCH_NUM)){ 

					// checking if the news id from comment field is equal with the id from fullArticle page to show the comments in respective news only...
					if ($comResult[3] == $id){
					?>
			<div class = "comments">
				<!-- showing username and date -->
				<div class = "username"><a href = "userComment.php?name=<?php echo $comResult[1]; ?>"><?php echo $comResult[1]; ?></a>&nbsp;•<em><?php echo $comResult[4]; ?></em></div>
				<!-- showing comment -->
				<div class = "commentTxt"><?php echo $comResult[2]; ?></div>
			</div>
			
			<?php }
		
		}
	}else{

		// if the comment table is empty...
		echo "<div class = 'comments'>No Comments!</div";
	}
			
			?>
		</div>
		</main>

		<footer>
			&copy; ASAP News 2024. All rights reserved.
		</footer>

	</body>
</html>

