<?php

// calling category database to store and execute category data...
include('categoryDB.php');
session_start();

//setting username and photo/user's image to display on profile
$nameOfUser = $_SESSION["username"];
$userPhoto = $_SESSION["photo"];

// getting specific category id...
$id = $_GET['id'];

// if session failed to fetch username, user can't access to any pages...
if (!$nameOfUser){
	header("Location:login.php");
}
require('layout.php');
?>
			<section class = "news_list_container">
                <h2 id = "heading"><?php
				// if the category is updated successfully, then it prompts the message...
						if($posted == true){
							echo "Category Updated Successfully!";
						}
						else{
							echo "Edit Category";
						}
					?></h2>
			</section>
			<!-- all the input fields are prefilled with the category data which is clicked for editing... -->
			<!-- form for writing the category data to database.. -->
            <form method = "POST" action="">
                <?php 

				// selecting the specific category data...
                    $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category` WHERE id = '$id'");

					// executing the selected data...
                    $statemnt->execute();

					// fetching the executed data...
                    $results = $statemnt->fetch(PDO::FETCH_NUM);
                    ?>

					<!-- Category name input field -->
                <label>Category Name</label> <input type="text" name="category" value = "<?php echo $results[1] ?>" style = "width: 30%;" required/>
                <?php
				// if category already exists, it prompts a message...
                if ($existedCtgs == true){
                    echo"<p style = 'clear: both; margin-left: 220px; color: red;'>*Category already exists</p>";
                }
				// if category name is invalid, it prompts a message...
				else if ($invalid_category == true){
					echo"<p style = 'clear: both; margin-left: 220px; color: red;'>Invalid Category Name! (Minimum 3 words required!)</p>";
				}
                ?>
				<!-- submit button -->
				<input type="submit" name="update" value="Update" />
				<!-- link for redirecting into manageCategories page -->
				<label class = "backbtn"><a href = "manageCategories.php"><i class='bx bx-arrow-back'></i>&nbsp;Back</a></label>
				</form>
				
		</main>

		<footer>
			&copy; ASAP News 2024. All rights reserved.
		</footer>

	</body>
</html>
