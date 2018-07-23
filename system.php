<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';

	if (isset($_POST['action'])){
		if(!empty($_POST["make"]) && !empty($_POST["model"]) && !empty($_POST["processor"])
			&& !empty($_POST["graphics"]) && !empty($_POST["ram"]) && !empty($_POST["hdd"]) && !empty($_POST["cd"]) && !empty($_POST["os"])) {
			$systemStandard = mysqli_real_escape_string($conn, $_POST['standard']);
			$systemMake = mysqli_real_escape_string($conn, $_POST['make']);
			$systemModel = mysqli_real_escape_string($conn, $_POST['model']);
			$systemProcessor = mysqli_real_escape_string($conn, $_POST['processor']);
			$systemGraphics = mysqli_real_escape_string($conn, $_POST['graphics']);
			$systemRAM = mysqli_real_escape_string($conn, $_POST['ram']);
			$systemHDD = mysqli_real_escape_string($conn, $_POST['hdd']);
			$systemCD = mysqli_real_escape_string($conn, $_POST['cd']);
			$systemOS = mysqli_real_escape_string($conn, $_POST['os']);

			$sql = "INSERT INTO system (Standard, Make, Model, Processor, Graphics_Card, RAM, Hard_Drive, `CD/DVD`, Operating_System)
				VALUES ('$systemStandard', '$systemMake', '$systemModel', '$systemProcessor', '$systemGraphics', '$systemRAM', '$systemHDD', '$systemCD', '$systemOS')";
			if ($conn->query($sql) === TRUE) {
				header("Location: system.php?submit=successAdded");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: system.php?error=required");
		}

		?>
		<h2>There was meant to be something here... Ooops!<h2>
		<?php
	} else if (isset($_POST['reviewerAction'])){
		if(!empty($_POST["reviewer"]) && !empty($_POST["system"])) {

			$systemID = mysqli_real_escape_string($conn, $_POST['system']);
			$reviewerID = mysqli_real_escape_string($conn, $_POST['reviewer']);
			if (empty($_POST["date"])) {
				$purchaseDate = 'NULL';
			} else {
				$purchaseDate = mysqli_real_escape_string($conn, date("Y-m-d", strtotime($_POST['date'])));
				$purchaseDate = "'".$purchaseDate."'";
			}

			$sql = "INSERT INTO reviewer_system (System_ID, Reviewer_ID, Purchase_Date)
				VALUES ('$systemID', '$reviewerID', $purchaseDate)";
			if ($conn->query($sql) === TRUE) {
				header("Location: system.php?submit=successAdded2");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: system.php?error=required2");
		}
	} else if (isset($_POST['update'])) {
		if(!empty($_POST["make"]) && !empty($_POST["model"]) && !empty($_POST["processor"])
			&& !empty($_POST["graphics"]) && !empty($_POST["ram"]) && !empty($_POST["hdd"]) && !empty($_POST["cd"]) && !empty($_POST["os"])){
			$systemStandard = mysqli_real_escape_string($conn, $_POST['standard']);
			$systemMake = mysqli_real_escape_string($conn, $_POST['make']);
			$systemModel = mysqli_real_escape_string($conn, $_POST['model']);
			$systemProcessor = mysqli_real_escape_string($conn, $_POST['processor']);
			$systemGraphics = mysqli_real_escape_string($conn, $_POST['graphics']);
			$systemRAM = mysqli_real_escape_string($conn, $_POST['ram']);
			$systemHDD = mysqli_real_escape_string($conn, $_POST['hdd']);
			$systemCD = mysqli_real_escape_string($conn, $_POST['cd']);
			$systemOS = mysqli_real_escape_string($conn, $_POST['os']);
			$id = mysqli_real_escape_string($conn, $_POST['id']);

			$sql = "UPDATE system SET Standard='$systemStandard', Make='$systemMake', Model='$systemModel', Processor='$systemProcessor', Graphics_Card='$systemGraphics', RAM='$systemRAM', Hard_Drive='$systemHDD', `CD/DVD`='$systemCD', Operating_System='$systemOS'
				WHERE ID='$id'";
			if ($conn->query($sql) === TRUE) {
				header("Location: system.php?submit=successUpdated");
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} else {
			header("Location: system.php?error=failed");
		}
	} else if (isset($_POST['edit'])) {
		$id = $_GET['id'];
		$sql = "SELECT * FROM system WHERE ID = $id";
		$query = mysqli_query($conn, $sql)
			or die('Error querying the database');

			if (mysqli_num_rows($query) == 0) {
				echo("No results found");
			} else {
				$rows = mysqli_fetch_assoc($query);
				?>
				<section class="main-container">
					<div class="main-wrapper">
					<form action="system.php" method="POST">
						<input name="update" type="hidden">
						<input name="id" type="hidden" value="<?php echo $rows['ID'];?>">
						<table>
							<tr>
								<td><h2>Update System</h2></td><td></td>
							</tr>
							<tr>
								<td>Standard or Custom built:</td>
								<td><select name="standard">
								  <option value="1">Standard</option>
								  <option value="0">Custom</option>
								</select></td>
							</tr>
							<tr>
								<td>Make: </td><td><input name="make" id="make" placeholder="Make *" type="text" value="<?php echo $rows['Make'];?>"></td>
							</tr>
							<tr>
								<td>Model: </td><td><input name="model" id="model" placeholder="Model *" type="text" value="<?php echo $rows['Model'];?>"></td>
							</tr>
							<tr>
								<td>Processor: </td><td><input name="processor" id="processor" placeholder="Processor *" type="text" value="<?php echo $rows['Processor'];?>"></td>
							</tr>
							<tr>
								<td>Graphics Card: </td><td><input name="graphics" id="graphics" placeholder="Graphics Card *" type="text" value="<?php echo $rows['Graphics_Card'];?>"></td>
							</tr>
							<tr>
								<td>RAM: </td><td><input name="ram" id="ram" placeholder="RAM*" type="text" value="<?php echo $rows['RAM'];?>"></td>
							</tr>
							<tr>
								<td>Hard Drive: </td><td><input name="hdd" id="hdd" placeholder="Hard Drive *" type="text" value="<?php echo $rows['Hard_Drive'];?>"></td>
							</tr>
							<tr>
								<td>CD/DVD: </td><td><select name="cd">
								  <option value="cd">CD</option>
								  <option value="dvd">DVD</option>
								  <option value="cd_dvd">CD+DVD</option>
								  <option value="none">None</option>
								</select></td>
							</tr>
							<tr>
								<td>Operating System: </td><td><select name="os">
								  <option value="Windows">Windows</option>
								  <option value="Linux">Linux</option>
								  <option value="MacOS">MacOS</option>
								  <option value="Other">Other</option>
								</select></td>
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
				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded") {
					echo "System Added Successfully!<br><br>";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successUpdated") {
					echo "System Updated Successfully!<br><br>";
				} ?>
				<form action="system.php" method="POST">
					<input name="action" type="hidden">
					<table>
						<tr>
							<td><h2>Computer System</h2></td><td></td><td></td>
						</tr>
						<tr>
							<td>Standard or Custom built: </td><td><select name="standard">
							  <option value="1">Standard</option>
							  <option value="0">Custom</option>
							</select></td><td></td>
						</tr>
						<tr>
							<td>Make: </td><td><input name="make" id="make" placeholder="Make *" type="text"></td><td></td>
						</tr>
						<tr>
							<td>Model: </td><td><input name="model" id="model" placeholder="Model *" type="text"></td><td></td>
						</tr>
						<tr>
							<td>Processor: </td><td><input name="processor" id="processor" placeholder="Processor *" type="text"></td><td></td>
						</tr>
						<tr>
							<td>Graphics Card: </td><td><input name="graphics" id="graphics" placeholder="Graphics Card *" type="text"></td><td></td>
						</tr>
						<tr>
							<td>RAM: </td><td><input name="ram" id="ram" placeholder="RAM*" type="text"></td><td></td>
						</tr>
						<tr>
							<td>Hard Drive: </td><td><input name="hdd" id="hdd" placeholder="Hard Drive *" type="text"></td><td></td>
						</tr>
						<tr>
							<td>CD/DVD:</td><td><select name="cd">
							  <option value="cd">CD</option>
							  <option value="dvd">DVD</option>
							  <option value="cd_dvd">CD+DVD</option>
							  <option value="none">None</option>
							</select></td><td></td>
						</tr>
						<tr>
							<td>Operating System: </td><td><select name="os">
							  <option value="Windows">Windows</option>
							  <option value="Linux">Linux</option>
							  <option value="MacOS">MacOS</option>
							  <option value="Other">Other</option>
							</select></td><td></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" value="Submit"></td><td></td>
						</tr>
				</form>

				<?php if(isset($_GET["error"]) && ($_GET["error"]) == "required2") {
					echo "Please fill required fields (*)";
				} else if(isset($_GET["submit"]) && ($_GET["submit"]) == "successAdded2") {
					echo "System Assigned Successfully!<br><br>";
				} ?>
				<form action="system.php" method="POST">
					<input name="reviewerAction" type="hidden">
					<table>
						<tr>
							<td><h2>Reviewer System</h2></td><td></td><td></td>
						</tr>
						<tr>
							<td>System to assign to Reviewer *:</td>
					<?php
						$sql = "SELECT ID, Make, Model FROM system";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><td><select name="system"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?>
								<option value="<?php echo $row['ID'];?>"><?php echo $row['Make']." - ".$row['Model'];?></option>
								<?php
							}
							?></select></td><td></td></tr><?php
						}
					?>
					<tr>
						<td>Reviewer *:</td>
					<?php
						$sql = "SELECT ID, Firstname, Surname FROM reviewer";
						$result = mysqli_query($conn, $sql)
							or die('Error querying the database');

						if (mysqli_num_rows($result) == 0) {
							echo("No results found");
						} else {
							?><td><select name="reviewer"><?php
							while($row = mysqli_fetch_assoc($result)) {
								?>
								<option value="<?php echo $row['ID'];?>"><?php echo $row['Firstname']." ".$row['Surname'];?></option>
								<?php
							}
							?></select></td><?php
						}
					?>
					<td><a href="reviewer.php">+ Add New Reviwer</a></td>
				</tr>
				<tr>
					<td>Purchase Date: </td><td><input name="date" id="date" placeholder="Purchase Date (yyyy-mm-dd)" type="date"></td><td></td>
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
