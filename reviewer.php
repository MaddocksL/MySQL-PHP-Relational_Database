<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["street"]) && !empty($_POST["town"]) && !empty($_POST["country"]) && !empty($_POST["postcode"]) && !empty($_POST["reviewerEmail"]) && !empty($_POST["phone"]) && !empty($_POST["dateStarted"]) && !empty($_POST["genre"]) && !empty($_POST["dob"]) && !empty($_POST["gender"])) {
			$reviewerFirst = mysqli_real_escape_string($conn, $_POST['firstName']);
			$reviewerLast = mysqli_real_escape_string($conn, $_POST['lastName']);
			$reviewerStreet = mysqli_real_escape_string($conn, $_POST['street']);
			$reviewerTown = mysqli_real_escape_string($conn, $_POST['town']);
			$reviewerCountry = mysqli_real_escape_string($conn, $_POST['country']);
			$reviewerPCode = mysqli_real_escape_string($conn, $_POST['postcode']);
			$reviewerEmail = mysqli_real_escape_string($conn, $_POST['reviewerEmail']);
			$reviewerPhone = mysqli_real_escape_string($conn, $_POST['phone']);
			$reviewerStart = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dateStarted'])));
			$reviewerGenre = mysqli_real_escape_string($conn, $_POST['genre']);
			$reviewerDOB = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dob'])));
			$reviewerGender = mysqli_real_escape_string($conn, $_POST['gender']);

			$sql = "INSERT INTO reviewer (Firstname, Surname, Street, Town, Country, Postcode, Email, Phone, Date_Started, Prefered_Genre_ID, Date_Of_Birth, Gender)
				VALUES ('$reviewerFirst', '$reviewerLast', '$reviewerStreet', '$reviewerTown', '$reviewerCountry', '$reviewerPCode', '$reviewerEmail', '$reviewerPhone', '$reviewerStart', '$reviewerGenre', '$reviewerDOB', '$reviewerGender')";
			if ($conn->query($sql) === TRUE) {
				header("Location: reviewer.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: reviewer.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
	<?php
	} else if (isset($_POST['update'])) {
		if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["street"]) && !empty($_POST["town"]) && !empty($_POST["country"]) && !empty($_POST["postcode"]) && !empty($_POST["reviewerEmail"]) && !empty($_POST["phone"]) && !empty($_POST["dateStarted"]) && !empty($_POST["genre"]) && !empty($_POST["dob"]) && !empty($_POST["gender"])) {
			$reviewerFirst = mysqli_real_escape_string($conn, $_POST['firstName']);
			$reviewerLast = mysqli_real_escape_string($conn, $_POST['lastName']);
			$reviewerStreet = mysqli_real_escape_string($conn, $_POST['street']);
			$reviewerTown = mysqli_real_escape_string($conn, $_POST['town']);
			$reviewerCountry = mysqli_real_escape_string($conn, $_POST['country']);
			$reviewerPCode = mysqli_real_escape_string($conn, $_POST['postcode']);
			$reviewerEmail = mysqli_real_escape_string($conn, $_POST['reviewerEmail']);
			$reviewerPhone = mysqli_real_escape_string($conn, $_POST['phone']);
			$reviewerStart = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dateStarted'])));
			$reviewerGenre = mysqli_real_escape_string($conn, $_POST['genre']);
			$reviewerDOB = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['dob'])));
			$reviewerGender = mysqli_real_escape_string($conn, $_POST['gender']);
			$id = mysqli_real_escape_string($conn, $_POST['id']);

			$sql = "UPDATE reviewer SET Firstname='$reviewerFirst', Surname='$reviewerLast', Street='$reviewerStreet', Town='$reviewerTown', Country='$reviewerCountry', Postcode='$reviewerPCode', Email='$reviewerEmail', Phone='$reviewerPhone', Date_Started='$reviewerStart', Prefered_Genre_ID='$reviewerGenre', Date_Of_Birth='$reviewerDOB', Gender='$reviewerGender' WHERE ID='$id'";
			if ($conn->query($sql) === TRUE) {
				header("Location: reviewer.php?submit=successUpdated");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: reviewer.php?error=failed");
		}
	} else if (isset($_POST['edit'])) {
		$id = $_GET['id'];
		$sql = "SELECT * FROM reviewer WHERE ID = $id";
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
						<form action="reviewer.php" method="POST">
							<input name="update" type="hidden">
							<input name="id" type="hidden" value="<?php echo $rows['ID'];?>">
							<table>
								<tr>
									<td>First Name: </td><td><input name="firstName" id="firstName" placeholder="First Name *" type="text" value="<?php echo $rows['Firstname'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Last Name: </td><td><input name="lastName" id="lastName" placeholder="Surname *" type="text" value="<?php echo $rows['Surname'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Street: </td><td><input name="street" id="street" placeholder="Street *" type="text" value="<?php echo $rows['Street'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Town: </td><td><input name="town" id="town" placeholder="Town *" type="text" value="<?php echo $rows['Town'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Country: </td><td><input name="country" id="country" placeholder="Country *" type="text" value="<?php echo $rows['Country'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Postcode: </td><td><input name="postcode" id="postcode" placeholder="Postcode *" type="text" value="<?php echo $rows['Postcode'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Email Addresss</td><td><input name="reviewerEmail" id="reviewerEmail" placeholder="Contact Email *" type="email" value="<?php echo $rows['Email'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Phone Number: </td><td><input name="phone" id="phone" placeholder="Contact Number *" type="text" value="<?php echo $rows['Phone'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Start Date: </td><td><input style="width: 200px;" name="dateStarted" id="dateStarted" placeholder="Date Started (yyyy-mm-dd) *" type="date" value="<?php echo $rows['Date_Started'];?>"></td><td></td>
								</tr>
								<tr>
									<td>Prefered Genre: </td><td>
							<?php
								$sql = "SELECT * FROM genre";
								$result = mysqli_query($conn, $sql)
									or die('Error querying the database');

								if (mysqli_num_rows($result) == 0) {
									echo("No results found");
								} else {
									?><select name="genre"><?php
									while($row = mysqli_fetch_assoc($result)) {
										?>
											<option value="<?php echo $row['ID'];?>"
												<?php if ($row['ID'] == $rows['Prefered_Genre_ID']) {
													echo "selected";
												} ?> ><?php echo $row['Genre'];?>
											</option>
										<?php
									}
									?></select></td><td></td>
								</tr><?php
								}
							?>
							<tr>
								<td>Date of Birth: </td><td><input style="width: 200px;" name="dob" id="dob" placeholder="Date Of Birth (yyyy-mm-dd) *" type="date" value="<?php echo $rows['Date_Of_Birth'];?>"></td><td></td>
							</tr>
							<tr>
								<td>Gender: </td><td><select name="gender">
								  <option value="male">Male</option>
								  <option value="female">Female</option>
								  <option value="other">Other</option>
								</select></td><td></td>
							</tr>
							<tr>
								<td></td><td><input type="submit" value="Submit"></td><td></td>
							</tr>

						</form>
					</div>
				</section>
				<?php
			}
	} else { ?>
		<section class="main-container">
			<div class="main-wrapper">
				<h2>Add Reviewer</h2>
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "Reviewer Added Successfully!<br><br>";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successUpdated") {
					echo "Reviewer Updated Successfully!<br><br>";
				} ?>
				<form action="reviewer.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr>
							<td>First Name: </td><td><input name="firstName" id="firstName" placeholder="First Name *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Last Name: </td><td><input name="lastName" id="lastName" placeholder="Surname *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Street: </td><td><input name="street" id="street" placeholder="Street *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Town: </td><td><input name="town" id="town" placeholder="Town *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Country: </td><td><input name="country" id="country" placeholder="Country *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Postcode: </td><td><input name="postcode" id="postcode" placeholder="Postcode *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Email Address: </td><td><input name="reviewerEmail" id="reviewerEmail" placeholder="Contact Email *" type="email"></td><td> </td>
						</tr>
						<tr>
							<td>Phone Number: </td><td><input name="phone" id="phone" placeholder="Contact Number *" type="text"></td><td> </td>
						</tr>
						<tr>
							<td>Start Date: </td><td><input style="width: 200px;" name="dateStarted" id="dateStarted" placeholder="Date Started (yyyy-mm-dd) *" type="date"></td><td> </td>
						</tr>
						<tr>
							<td>Prefered Genre: </td><td>
					<?php
						$sql = "SELECT * FROM genre";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><select name="genre"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?><option value="<?php echo $row['ID'];?>"><?php echo $row['Genre'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="genre.php">+ Add New Genre</a></td>
				</tr>
				<tr>
					<td>Date of Birth: </td><td><input style="width: 200px;" name="dob" id="dob" placeholder="Date Of Birth (yyyy-mm-dd) *" type="date"></td><td></td>
				</tr>
				<tr>
					<td>Gender: </td><td><select name="gender">
					  <option value="male">Male</option>
					  <option value="female">Female</option>
					  <option value="other">Other</option>
					</select></td><td></td>
				</tr>
				<tr>
					<td></td><td><input type="submit" value="Submit"></td><td></td>
				</tr>
			</table>
				</form>
			</div>
		</section>
		<?php
	}
	mysqli_close($conn); ?>
<?php
	include_once 'templates/footer.php';
?>
