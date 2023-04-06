<?php
session_start();
require_once "conn.php";
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true) {
	header("location: log-in.php");
	exit;
}

$Total = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 0;
?>
<!DOCTYPE html>
<html>

<head>
	<title>Confirm Order</title>
</head>

<body>
	<h1>Confirm Order</h1>
	<div class="confirm">
		<table>
			<thead>
				<tr>
					<th></th>
					<th>Product</th>
					<th>Size(ml)</th>
					<th>Price</th>
					<th>Subtotal</th>
				</tr>
			</thead>

			<tbody>
				<?php
				//initialize total
				$total = 0;
				if (!empty($_SESSION['cart'])) {
					//create array of initial qty which is 1
					$index = 0;
					if (!isset($_SESSION['qty_array'])) {
						$_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
					}
					$sql = "SELECT * FROM products WHERE id IN (" . implode(',', $_SESSION['cart']) . ")";
					$query = $mysqli->query($sql);
					while ($row = $query->fetch_assoc()) {
				?>
						<tr>

							<td>
								<a href="delete_item.php?id=<?php echo $row['id']; ?>&index=<?php echo $index; ?>"><i class="fa-solid fa-trash"></i></a>
							</td>

							<td style="margin:40px;"><?php echo $row['Name']; ?></td>
							<td style="margin:40px;"><?php echo $row['sizes'];
														'ml' ?></td>
							<td><?php echo number_format($row['product_Price'], 2); ?></td>
							<input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
							<td><?php echo number_format($_SESSION['qty_array'][$index] * $row['product_Price'], 2); ?></td>
							<?php $total += $_SESSION['qty_array'][$index] * $row['product_Price'];
							?>
						</tr>
					<?php
						$index++;
					}
				} else {
					?>
					<tr>
						<td colspan="4" style="text-align: center; justify-content:center;">
							No Item in Cart
						</td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="4" align="right"><b>Total</b></td>
					<td><b><?php echo number_format($Total, 2); ?></b></td>
				</tr>

			</tbody>

		</table>
		<form method="POST" action="confirm.php">

			<input type="text" name="name" id="name" placeholder="Insert your full name" required><br>

			<input type="text" name="phone" id="phone" placeholder="insert your phone number" required><br>

			<input type="email" placeholder="insert your email address" name="email" id="email"><br>

			<input type="text" name="address" placeholder="insert your delivery address" id="address"><br>

			<input type="text" placeholder="Insert Your Contry" name="country" value="Nigeria" id="country" disabled><br>

			<input type="text" id="total_price" name="total_price" value="<?php echo $Total; ?>" disabled>
			<div class="buttons">

				<a href="cart.php" class="btn"> Back</a>
				<button type="submit" class="btn" name="Confirm_order">Confirm</button>
			</div>
			<!-- <a href="clear_cart.php" class="btn"> Clear Cart</a>
				<a href="check.php" class="btn">Checkout</a> -->
	</div>

	</form>
</body>

</html>
<style>
	body {
		background-color: #fff;
		color: black;
		font-family: Arial, sans-serif;
	}

	h1 {
		color: #d4af37;
		text-align: center;
		font-weight: bold;
		text-transform: uppercase;
		margin-top: 50px;
	}

	.confirm {
		display: flex;
		flex-direction: row;
		align-items: flex-start;
		justify-content: space-between;
	}

	form {
		width: 50%;
		margin-right: 20px;
	}

	table {
		width: 50%;
	}

	/* .confirm {
		display: flex;
		flex-wrap: wrap;
	}

	form {
		flex-basis: 40%;
		padding: 20px;
		box-sizing: border-box;
	}

	table {
		flex-basis: 55%;
		padding: 10px;
		box-sizing: border-box;
	} */

	form {
		margin-top: 30px;
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	input[type="text"],
	input[type="email"] {
		padding: 10px;
		border-radius: 5px;
		border: none;
		margin-bottom: 10px;
		width: 300px;
	}

	input[type="text"]:focus,
	input[type="email"]:focus {
		outline: none;
		box-shadow: 0px 0px 5px #d4af37;
	}

	input[type="text"]::placeholder,
	input[type="email"]::placeholder {
		color: #808080;
	}

	input[type="text"][disabled],
	input[type="email"][disabled] {
		background-color: #d3d3d3;
	}

	input[type="submit"] {
		background-color: goldenrod;
		color: #fff;
		padding: 10px 20px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		margin-top: 20px;
		transition: all 0.3s ease;
	}

	input[type="submit"]:hover {
		background-color: #fff;
		color: #d4af37;
		border: 1px solid #d4af37;
	}

	table {
		align-items: center;
		border-collapse: collapse;
		margin: 50px auto auto 30px;
	}

	th {
		background-color: goldenrod;
		color: #fff;
		font-weight: bold;
		padding: 10px;
		text-align: left;
	}

	td {
		padding: 10px;
	}

	tbody tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	tbody tr:hover {
		background-color: #ddd;

	}

	.fa-solid.fa-trash {
		color: #d4af37;
		font-size: 1.2rem;
	}

	.buttons {
		display: flex;
		right: 0;
	}

	.btn {
		background-color: goldenrod;
		color: #fff;
		padding: 10px 20px;
		border: none;
		border-radius: 5px;
		cursor: pointer;
		margin: 20px 10px;
		text-align: center;
		transition: all 0.3s ease;
		text-decoration: none;
		text-transform: uppercase;
	}

	.btn:hover {
		background-color: #fff;
		color: #d4af37;
		border: 1px solid #d4af37;
	}

	@media screen and (max-width: 768px) {

		input[type="text"],
		input[type="email"] {
			width: 100%;
		}

		table {
			width: 100%;
		}

		th:nth-child(3),
		td:nth-child(3) {
			display: none;
		}
	}
</style>