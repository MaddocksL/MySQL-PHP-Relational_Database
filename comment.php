<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["reviewer"]) && !empty($_POST["game"]) && !empty($_POST["comment"])) {
			$commentGameID = mysqli_real_escape_string($conn, $_POST['game']);
			$commentReviewerID = mysqli_real_escape_string($conn, $_POST['reviewer']);
			$comment = mysqli_real_escape_string($conn, $_POST['comment']);

			$sql = "INSERT INTO review_comment (Game_Version_ID, Reviewer_ID, Comment)
				VALUES ('$commentGameID', '$commentReviewerID', '$comment')";
			if ($conn->query($sql) === TRUE) {
				header("Location: comment.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: comment.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
		<?php
	} else if (isset($_POST['update'])) {
		if(!empty($_POST["reviewer"]) && !empty($_POST["game"]) && !empty($_POST["comment"])) {
			$commentGameID = mysqli_real_escape_string($conn, $_POST['game']);
			$commentReviewerID = mysqli_real_escape_string($conn, $_POST['reviewer']);
			$comment = mysqli_real_escape_string($conn, $_POST['comment']);
			$id = mysqli_real_escape_string($conn, $_POST['id']);

			$sql = "UPDATE review_comment SET Game_Version_ID='$commentGameID', Reviewer_ID='$commentReviewerID', Comment='$comment'
				WHERE Comment_ID='$id'";
			if ($conn->query($sql) === TRUE) {
				header("Location: comment.php?submit=successUpdated");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: comment.php?error=failed");
		}
	} else if (isset($_POST['edit'])) {
		$id = $_GET['id'];
		$sql = "SELECT * FROM review_comment WHERE Comment_ID = $id";
		$query = mysqli_query($conn, $sql)
			or die('Error querying the database');

			if (mysqli_num_rows($query) == 0) {
				echo("No results found");
			} else {
				$rows = mysqli_fetch_assoc($query);
				?>
				<section class="main-container">
					<div class="main-wrapper">
						<h2>Update Reviewer</h2>
						<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
							echo "Please fill required fields (*)";
						} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
							echo "Reviewer Added Successfully!<br><br>";
						} ?>
						<form action="comment.php" method="POST">
							<input name="update" type="hidden">
							<input name="id" type="hidden" value="<?php echo $rows['Comment_ID'];?>">
							<table>
								<tr>
									<td>Game: </td><td>
							<?php
								$sql = "SELECT game_version.ID, game_version.Game_ID, game_version.Version_Number, game.Game_Name FROM game_version INNER JOIN game ON game_version.Game_ID = game.ID  ORDER BY game.Game_Name ASC";
								$result = mysqli_query($conn, $sql)
									or die('Error querying the database');

								if (mysqli_num_rows($result) == 0) {
									echo("No results found");
								} else {
									?><select name="game"><?php
									while($row = mysqli_fetch_assoc($result)) {
										?>
											<option value="<?php echo $row['ID'];?>"
												<?php if ($row['ID'] == $rows['Game_Version_ID']) {
													echo "selected";
												} ?> ><?php echo $row['Game_Name']." - Version: ". $row['Version_Number'];?>
											</option>
										<?php
									}
									?></select></td></tr><?php
								}
							?>
							<tr>
								<td>Reviewer:</td><td>
							<?php
								$sql = "SELECT ID, Firstname, Surname FROM reviewer";
								$result = mysqli_query($conn, $sql)
									or die('Error querying the database');

								if (mysqli_num_rows($result) == 0) {
									echo("No results found");
								} else {
									?><select name="reviewer"><?php
									while($row = mysqli_fetch_assoc($result)) {
										?>
											<option value="<?php echo $row['ID'];?>"
												<?php if ($row['ID'] == $rows['Reviewer_ID']) {
													echo "selected";
												} ?> ><?php echo $row['Firstname']." ".$row['Surname'];?>
											</option>
										<?php
									}
									?></select></td></tr><?php
								}
							?>
							<tr>
								<td>Comment: </td><td><input style="width: 500px;" name="comment" id="comment" placeholder="Comment *" type="text" value="<?php echo $rows['Comment'];?>"></td>
							</tr>
							<tr>
								<td></td><td><input type="submit" value="Submit"></td>
							</tr>
						</table>
						</form>
					</div>
				</section>
				<?php
			}
	} else { ?>
		<section class="main-container">
			<div class="main-wrapper">
				<h2>Comment</h2>
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "Game Comment Added Successfully!<br><br>";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successUpdated") {
					echo "Comment Updated Successfully!<br><br>";
				} ?>
				<form action="comment.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr>
							<td>Reviewer *:</td>
							<td>
					<?php
						$sql = "SELECT ID, Firstname, Surname FROM reviewer";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><select name="reviewer"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?>
								<option value="<?php echo $row['ID'];?>"><?php echo $row['Firstname']." ".$row['Surname'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="reviewer.php">+ Add New Reviewer</a></td>
				</tr>
				<tr>
					<td>Game *: </td><td>
					<?php
						$sql = "SELECT game_version.ID, game_version.Game_ID, game_version.Version_Number, game.Game_Name FROM game_version INNER JOIN game ON game_version.Game_ID = game.ID  ORDER BY game.Game_Name ASC";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><select name="game"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Game_Name']." - Version: ". $row['Version_Number'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="game.php">+ Add New Game or Version</a></td>
				</tr>
				<tr>
					<td>Comment: </td><td><input style="width: 500px;" name="comment" id="comment" placeholder="Comment *" type="text"></td><td></td>
				</tr>
				<tr>
					<td></td><td><input type="submit" value="Submit"></td><td></td>
				</tr>
			</table>
				</form>
			</div>
		</section>
	<?php }
	mysqli_close($conn); ?>
<?php
	include_once 'templates/footer.php';
?>
