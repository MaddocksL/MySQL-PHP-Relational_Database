<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["game"]) && !empty($_POST["reviewer"]) && !empty($_POST["system"]) && !empty($_POST["graphics"]) && !empty($_POST["sound"]) && !empty($_POST["gameplay"]) && !empty($_POST["overall"]) && !empty($_POST["dateSent"]) && !empty($_POST["dateReviewed"])) {
			$reviewGameID = mysqli_real_escape_string($conn, $_POST['game']);
			$reviewReviewerID = mysqli_real_escape_string($conn, $_POST['reviewer']);
			$reviewSystemID = mysqli_real_escape_string($conn, $_POST['system']);
			$reviewGraphics = mysqli_real_escape_string($conn, $_POST['graphics']);
			$reviewSound = mysqli_real_escape_string($conn, $_POST['sound']);
			$reviewGameplay = mysqli_real_escape_string($conn, $_POST['gameplay']);
			$reviewOverall = mysqli_real_escape_string($conn, $_POST['overall']);
			$reviewDateSent = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dateSent'])));
			$reviewDateReviewed = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dateReviewed'])));
			$reviewDate = mysqli_real_escape_string($conn, date("Y-m-d", strtotime(date('Y-m-d'))));

			$sql = "INSERT INTO game_review (Game_Version_ID, Reviewer_ID, System_ID, Graphics_Rating, Sound_Rating, Gameplay_Rating, Overall_Score, Date_Game_Sent, Date_of_Review, Date_Review_Recieved)
				VALUES ('$reviewGameID', '$reviewReviewerID', '$reviewSystemID', '$reviewGraphics', '$reviewSound', '$reviewGameplay', '$reviewOverall', '$reviewDateSent', '$reviewDateReviewed', '$reviewDate')";
			if ($conn->query($sql) === TRUE) {
				header("Location: review.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: review.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
		<?php
	} else if (isset($_POST['update'])) {
		if(!empty($_POST["game"]) && !empty($_POST["reviewer"]) && !empty($_POST["system"]) && !empty($_POST["graphics"]) && !empty($_POST["sound"]) && !empty($_POST["gameplay"]) && !empty($_POST["overall"]) && !empty($_POST["dateSent"]) && !empty($_POST["dateReviewed"])) {
			$reviewGameID = mysqli_real_escape_string($conn, $_POST['game']);
			$reviewReviewerID = mysqli_real_escape_string($conn, $_POST['reviewer']);
			$reviewSystemID = mysqli_real_escape_string($conn, $_POST['system']);
			$reviewGraphics = mysqli_real_escape_string($conn, $_POST['graphics']);
			$reviewSound = mysqli_real_escape_string($conn, $_POST['sound']);
			$reviewGameplay = mysqli_real_escape_string($conn, $_POST['gameplay']);
			$reviewOverall = mysqli_real_escape_string($conn, $_POST['overall']);
			$reviewDateSent = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dateSent'])));
			$reviewDateReviewed = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dateReviewed'])));
			$id = mysqli_real_escape_string($conn, $_POST['id']);

			$sql = "UPDATE game_review SET Game_Version_ID='$reviewGameID', Reviewer_ID='$reviewReviewerID', System_ID='$reviewSystemID', Graphics_Rating='$reviewGraphics', Sound_Rating='$reviewSound', Gameplay_Rating='$reviewGameplay', Overall_Score='$reviewOverall', Date_Game_Sent='$reviewDateSent', Date_of_Review='$reviewDateReviewed' WHERE ID='$id'";
			if ($conn->query($sql) === TRUE) {
				header("Location: review.php?submit=successUpdated");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: review.php?error=failed");
		}
	} else if (isset($_POST['edit'])) {
		$id = $_GET['id'];
		$sql = "SELECT * FROM game_review WHERE ID = $id";
		$query = mysqli_query($conn, $sql)
			or die('Error querying the database');

			if (mysqli_num_rows($query) == 0) {
				echo("No results found");
			} else {
				$rows = mysqli_fetch_assoc($query);
				?>
				<section class="main-container">
					<div class="main-wrapper">
						<h2>Update Review</h2>
						<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
							echo "Please fill required fields (*)";
						} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
							echo "Reviewer Added Successfully!<br><br>";
						} ?>
						<form action="review.php" method="POST">
							<input name="update" type="hidden">
							<input name="id" type="hidden" value="<?php echo $rows['ID'];?>">
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
								<td>System Used: </td><td>
							<?php
								$sql = "SELECT ID, Make, Model FROM system";
								$result = mysqli_query($conn, $sql)
									or die('Error querying the database');

								if (mysqli_num_rows($result) == 0) {
									echo("No results found");
								} else {
									?><select name="system"><?php
									while($row = mysqli_fetch_assoc($result)) {
										?>
											<option value="<?php echo $row['ID'];?>"
												<?php if ($row['ID'] == $rows['System_ID']) {
													echo "selected";
												} ?> ><?php echo $row['Make']." - ".$row['Model'];?>
											</option>
										<?php
									}
									?></select></td></tr><?php
								}
							?>
							<tr>
								<td>Graphics Rating (1-10) *: </td><td><input style="width: 50px" name="graphics" id="graphics" type="number" min="1" max="10" value="<?php echo $rows['Graphics_Rating'];?>"></td>
							</tr>
							<tr>
								<td>Sound Rating (1-10) *: </td><td><input style="width: 50px" name="sound" id="sound" type="number" min="1" max="10" value="<?php echo $rows['Sound_Rating'];?>"></td>
							</tr>
							<tr>
								<td>Gameplay Rating (1-10) *: </td><td><input style="width: 50px" name="gameplay" id="gameplay" type="number" min="1" max="10" value="<?php echo $rows['Gameplay_Rating'];?>"></td>
							</tr>
							<tr>
								<td>Overall Rating (1-10) *: </td><td><input style="width: 50px" name="overall" id="overall" type="number" min="1" max="10" value="<?php echo $rows['Overall_Score'];?>"></td>
							</tr>
							<tr>
								<td>Date Sent *: </td><td><input name="dateSent" id="dateStarted" placeholder="Date Game Sent (yyyy-mm-dd) *" type="date" value="<?php echo $rows['Date_Game_Sent'];?>"></td>
							</tr>
							<tr>
								<td>Date Received *: </td><td><input name="dateReviewed" id="dateStarted" placeholder="Date Reviewed (yyyy-mm-dd) *" type="date" value="<?php echo $rows['Date_of_Review'];?>"></td>
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
				<h2>Game Review</h2>
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "Review Added Successfully!<br><br>";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successUpdated") {
					echo "Review Updated Successfully!<br><br>";
				} ?>

				<form action="review.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr>
							<td>Game:</td><td>
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
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Firstname']." ".$row['Surname'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="reviewer.php">+ Add New Reviewer</a></td>
				</tr>
				<tr>
					<td>System Used: </td>
					<td>
					<?php
						$sql = "SELECT ID, Make, Model FROM system";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><select name="system"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Make']." - ".$row['Model'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="system.php">+ Add New System</a></td>
				</tr>
				<tr>
					<td>Graphics Rating (1-10) *: </td><td><input style="width: 50px" name="graphics" id="graphics" type="number" min="1" max="10" value="1"></td><td></td>
				</tr>
				<tr>
					<td>Sound Rating (1-10) *: </td><td><input style="width: 50px" name="sound" id="sound" type="number" min="1" max="10" value="1"></td>
				</tr>
				<tr>
					<td>Gameplay Rating (1-10) *: </td><td><input style="width: 50px" name="gameplay" id="gameplay" type="number" min="1" max="10" value="1"></td><td></td>
				</tr>
				<tr>
					<td>Overall Rating (1-10) *: </td><td><input style="width: 50px" name="overall" id="overall" type="number" min="1" max="10" value="1"></td><td></td>
				</tr>
				<tr>
					<td>Date Sent: </td><td><input name="dateSent" id="dateStarted" placeholder="Date Game Sent (yyyy-mm-dd) *" type="date"></td><td></td>
				</tr>
				<tr>
					<td>Date Reviewed: </td><td><input name="dateReviewed" id="dateStarted" placeholder="Date Reviewed (yyyy-mm-dd) *" type="date"></td><td></td>
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
