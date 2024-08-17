<?php
include('categoryDB.php');
session_start();

//setting username to show on profile
$nameOfUser = $_SESSION["username"];

//setting photo/user's image to display on profile
$userPhoto = $_SESSION["photo"];

// if session is not set, then user redirects to login page.
if (!$nameOfUser){
	header("Location:login.php");
}
// require()
include('layout.php');
// include 'layout.php' ;
?>


			<section class = "news_list_container">
                <h2 id = "heading">ALL CATEGORIES</h2>
			</section>
            <div class = "details" id = "ctgTable">
           <table>
                <tr>
                    <th>S.No</th>
                    <th>Category Name</th>
                    <th>Action</th>
                </tr>
                <?php
				// selecting all data from category table...
                $statemnt = $connection->prepare("SELECT * FROM `assignment1`.`category`");

				//executing selected data...
                $statemnt->execute();

				//initializing the number variable...
				$number = 0;

				// fetching all executed data..
                while ($ctgResults = $statemnt->fetch(PDO::FETCH_NUM)){
					$number+=1;
                    echo "<tr>";
                    echo "<td>". $number."</td>";

					// category name
                    echo "<td>". $ctgResults[1]."</td>"; ?>
                    <?php

					// if more than one categories are available, admins can delete any of those...
                    if($statemnt->rowCount() > 1){
                        echo "<td><a href='editCategory.php?id=$ctgResults[0]'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='deleteCategory.php?name=$ctgResults[1]'>Delete</a></td>";
                    }

					// but if only one category is available, admin cannot delete the last category...
                    else{
                        echo "<td><a href='editCategory.php?id=$ctgResults[0]'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a>Delete</a></td>";
                    }
                    echo "</tr>";
                }
                ?>
                </table>
            </div>
			<!-- link for redirecting to addCategory page -->
                <p class = "addLink"> <a href = "addCategory.php">Add New Category</a></p>
		</main>

		<footer>
			&copy; ASAP News 2024. All rights reserved.
		</footer>

	</body>
</html>
