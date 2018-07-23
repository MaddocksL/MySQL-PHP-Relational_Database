<?php
	include_once 'templates/header.php';
?>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #545454;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
tr:hover {
	background: #9e9bc7;
}
</style>

<section class="main-container">
	<div class="main-admin-wrapper">
<?php
	require 'includes/dbh.php';

	$action ='null';
	if (isset($_POST['action'])) {
	    $action = $_POST['action'];
	}

	switch ($action) {
		case 'Publisher':
			$sql = "SELECT * FROM publisher";
			$result = mysqli_query($conn, $sql)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				?>
				<table>
					<tr>
						<th>ID</th>
						<th>Publisher Name</th>
						<th>Contact Firstname</th>
						<th>Contact Lastname</th>
						<th>Publisher Email</th>
						<th>Edit</th>
					</tr>
					<?php
					while($row = mysqli_fetch_assoc($result)) {
						?><tr>
							<td><?php echo $row['ID'];?></td>
							<td><?php echo $row['Publisher_Name'];?></td>
							<td><?php echo $row['Contact_Firstname'];?></td>
							<td><?php echo $row['Contact_Surname'];?></td>
							<td><?php echo $row['Publisher_Email'];?></td>
							<td>
								<form action="publisher.php?id=<?php echo $row['ID'];?>" method="POST">
									<input type="submit" name="edit" value="Edit">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
				</table><br><br>
				<a href="publisher.php ?>">Add Publisher</a>
				<?php
			}
			break;

		case 'Game':
			$sql = "SELECT game.ID, game.Game_Name, game.Release_Date, game.Certificate, publisher.Publisher_Name, genre.Genre
					FROM game
					INNER JOIN publisher ON game.Publisher_ID = publisher.ID
					INNER JOIN genre ON game.Genre_ID = genre.ID
					ORDER BY publisher.Publisher_Name ASC, game.Release_Date ASC";
			$result = mysqli_query($conn, $sql)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				?>
				<table>
					<tr>
						<th>ID</th>
						<th>Publisher Name</th>
						<th>Game Name</th>
						<th>Genre</th>
						<th>Certificate</th>
						<th>Release Date</th>
						<th>Edit</th>
					</tr>
					<?php
					while($row = mysqli_fetch_assoc($result)) {
						?><tr>
							<td><?php echo $row['ID'];?></td>
							<td><?php echo $row['Publisher_Name'];?></td>
							<td><?php echo $row['Game_Name'];?></td>
							<td><?php echo $row['Genre'];?></td>
							<td><?php echo $row['Certificate'];?></td>
							<td><?php echo $row['Release_Date'];?></td>
							<td>
								<form action="game.php?id=<?php echo $row['ID'];?>" method="POST">
									<input type="submit" name="edit" value="Edit">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
				</table><br><br>
				<a href="publisher.php ?>">Add Publisher</a><br>
				<a href="game.php">Add Game</a><br>
				<a href="genre.php">Add Genre</a>
				<?php
			}
			break;

		case 'Reviewer':
			$sql = "SELECT reviewer.ID, reviewer.Firstname, reviewer.Surname, reviewer.Street, reviewer.Town, reviewer.Country, reviewer.Postcode, reviewer.Email, reviewer.Phone, reviewer.Date_Started, reviewer.Prefered_Genre_ID, reviewer.Date_Of_Birth, reviewer.Gender, genre.Genre FROM `reviewer`
				INNER JOIN genre ON reviewer.Prefered_Genre_ID = genre.ID";
			$result = mysqli_query($conn, $sql)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				?>
				<table>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Address</th>
						<th>Country</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Prefered Genre</th>
						<th>D.O.B</th>
						<th>Gender</th>
						<th>Edit</th>
					</tr>
					<?php
					while($row = mysqli_fetch_assoc($result)) {
						?><tr>
							<td><?php echo $row['ID'];?></td>
							<td><?php echo $row['Firstname']." ".$row['Surname'];?></td>
							<td><?php echo $row['Street']."<br>".$row['Town']."<br>".$row['Postcode'];?></td>
							<td><?php echo $row['Country'];?></td>
							<td><?php echo $row['Email'];?></td>
							<td><?php echo $row['Phone'];?></td>
							<td><?php echo $row['Genre'];?></td>
							<td><?php echo $row['Date_Of_Birth'];?></td>
							<td><?php echo $row['Gender'];?></td>
							<td>
								<form action="reviewer.php?id=<?php echo $row['ID'];?>" method="POST">
									<input type="submit" name="edit" value="Edit">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
				</table><br><br>
				<a href="reviewer.php">Add Reviewer</a><br><br>
				<a href="genre.php">Add Genre</a>
				<?php
			}
			break;

		case 'System':
			$sql = "SELECT * FROM system";
			$result = mysqli_query($conn, $sql)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				?>
				<table>
					<tr>
						<th>ID</th>
						<th>Standard</th>
						<th>Make</th>
						<th>Model</th>
						<th>Processor</th>
						<th>Graphics</th>
						<th>RAM</th>
						<th>Hard Drive</th>
						<th>CD/DVD</th>
						<th>OS</th>
						<th>Edit</th>
					</tr>
					<?php
					while($row = mysqli_fetch_assoc($result)) {
						?><tr>
							<td><?php echo $row['ID'];?></td>
							<td><?php echo $row['Standard'];?></td>
							<td><?php echo $row['Make'];?></td>
							<td><?php echo $row['Model'];?></td>
							<td><?php echo $row['Processor'];?></td>
							<td><?php echo $row['Graphics_Card'];?></td>
							<td><?php echo $row['RAM'];?></td>
							<td><?php echo $row['Hard_Drive'];?></td>
							<td><?php echo $row['CD/DVD'];?></td>
							<td><?php echo $row['Operating_System'];?></td>
							<td>
								<form action="system.php?id=<?php echo $row['ID'];?>" method="POST">
									<input type="submit" name="edit" value="Edit">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
				</table><br><br>
				<a href="system.php">Add Reviewer System</a>
				<?php
			}
			break;

		case 'Review':
			$sql = "SELECT game_review.ID, game.Game_Name, game_version.Version_Number, reviewer.Firstname, reviewer.Surname, system.Make, system.Model, game_review.Graphics_Rating, game_review.Sound_Rating, game_review.Gameplay_Rating, game_review.Overall_Score, game_review.Date_Game_Sent, game_review.Date_of_Review,
				(SELECT AVG(sub_game_review.Overall_Score)
				 FROM game_review as sub_game_review
			 	 WHERE sub_game_review.Game_Version_ID = game_review.Game_Version_ID) as Average_Score
				FROM game_review
				INNER JOIN game_version ON game_review.Game_Version_ID = game_version.ID
				INNER JOIN game ON game_version.Game_ID = game.ID
				INNER JOIN reviewer ON game_review.Reviewer_ID = reviewer.ID
				INNER JOIN system ON game_review.System_ID = system.ID";
			$result = mysqli_query($conn, $sql)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				?>
				<table>
					<tr>
						<th>ID</th>
						<th>Game</th>
						<th>Reviewer</th>
						<th>System</th>
						<th>Graphics</th>
						<th>Sound</th>
						<th>Gameplay</th>
						<th>Overall</th>
						<th>Date Sent</th>
						<th>Date of Review</th>
						<th>Avg. Score</th>
						<th>Edit</th>
					</tr>
					<?php
					while($row = mysqli_fetch_assoc($result)) {
						?><tr>
							<td><?php echo $row['ID'];?></td>
							<td><?php echo $row['Game_Name']." - Version: ".$row['Version_Number'];?></td>
							<td><?php echo $row['Firstname']." ".$row['Surname'];?></td>
							<td><?php echo $row['Make']." - ".$row['Model'];?></td>
							<td><?php echo $row['Graphics_Rating'];?></td>
							<td><?php echo $row['Sound_Rating'];?></td>
							<td><?php echo $row['Gameplay_Rating'];?></td>
							<td><?php echo $row['Overall_Score'];?></td>
							<td><?php echo $row['Date_Game_Sent'];?></td>
							<td><?php echo $row['Date_of_Review'];?></td>
							<td><?php echo (int)$row['Average_Score'];?></td>
							<td>
								<form action="review.php?id=<?php echo $row['ID'];?>" method="POST">
									<input type="submit" name="edit" value="Edit">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
				</table><br><br>
				<a href="review.php">Add Review</a>
				<?php
			}
			break;

		case 'Comment':
			$sql = "SELECT review_comment.Comment_ID, game.Game_Name, game_version.Version_Number, reviewer.Firstname, reviewer.Surname, review_comment.Comment FROM review_comment
				INNER JOIN game_version ON review_comment.Game_Version_ID = game_version.ID INNER JOIN game ON game_version.game_ID = game.ID
				INNER JOIN reviewer ON review_comment.Reviewer_ID = reviewer.ID
				ORDER BY `game`.`Game_Name` ASC, `game_version`.`Version_Number` ASC";
			$result = mysqli_query($conn, $sql)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				?>
				<table>
					<tr>
						<th>ID</th>
						<th>Game</th>
						<th>Reviewer</th>
						<th>Comment</th>
						<th>Edit</th>
					</tr>
					<?php
					while($row = mysqli_fetch_assoc($result)) {
						?><tr>
							<td><?php echo $row['Comment_ID'];?></td>
							<td><?php echo $row['Game_Name']." - Version: ".$row['Version_Number'];?></td>
							<td><?php echo $row['Firstname']." ".$row['Surname'];?></td>
							<td><?php echo $row['Comment'];?></td>
							<td>
								<form action="comment.php?id=<?php echo $row['Comment_ID'];?>" method="POST">
									<input type="submit" name="edit" value="Edit">
								</form>
							</td>
						</tr>
						<?php
					}
					?>
				</table><br><br>
				<a href="comment.php">Add Comment</a>
				<?php
			}
			break;

	default:
		break;
}

?>
	</div>
</section>

<?php
	include_once 'templates/footer.php';
?>
