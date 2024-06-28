<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>

<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$product = $conn->query("SELECT * FROM products WHERE id ='$id'");
	$product->execute();
	$singleProduct = $product->fetch(PDO::FETCH_OBJ);


	$related_products = $conn->query("SELECT * FROM products WHERE type='$singleProduct->type' AND id!='$singleProduct->id'");
	$related_products->execute();

	$allReleatedProducts = $related_products->fetchAll(PDO::FETCH_OBJ);
}


if (isset($_POST['submit'])) {
	$insert_cart = $conn->prepare("INSERT INTO cart (product_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)");
	$insert_cart->execute([
		":user_id" => $_SESSION['user_id'],
		":product_id" => $id,
		":quantity" => $_POST['quantity']
	]);


	echo '<script>alert("added to cart successfully");</script>';
}


if(isset($_SESSION['user_id'])){

	$validateCart = $conn->query("SELECT * FROM cart WHERE product_id='$id' AND user_id ='$_SESSION[user_id]'");
	
	$validateCart->execute();
	$rowCount = $validateCart->rowCount();
}


?>
<section class="home-slider owl-carousel">

	<div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">

				<div class="col-md-7 col-sm-12 text-center ftco-animate">
					<h1 class="mb-3 mt-5 bread">Product Detail</h1>
					<p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Product Detail</span></p>
				</div>

			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-5 ftco-animate">
				<a href="images/menu-2.jpg" class="image-popup"><img src="<?php echo APPURL; ?>/images/<?php echo $singleProduct->image; ?>" class="img-fluid" alt="Colorlib Template"></a>
			</div>
			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
				<h3><?php echo $singleProduct->name; ?></h3>
				<p class="price"><span>$<?php echo $singleProduct->price; ?></span></p>
				<p><?php echo $singleProduct->description ?></p>
				<form method="POST" action="product-single.php?id=<?php echo $id; ?>">
					<div class="row mt-4">
						<div class="w-100"></div>
						<div class="input-group col-md-6 d-flex mb-3">
							<span class="input-group-btn mr-2">
								<button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
									<i class="icon-minus"></i>
								</button>
							</span>
							<input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="100">
							<span class="input-group-btn ml-2">
								<button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
									<i class="icon-plus"></i>
								</button>
							</span>
						</div>
					</div>
					<input type="hidden" value="<?php echo $singleProduct->id; ?>" name="id">
					<?php if(isset($_SESSION['user_id'])) : ?>
						<?php if($rowCount > 0) : ?>
							<button type="submit" name="submit" class="" disabled>Added to Cart</button>
						<?php else: ?>
							<button type="submit" name="submit" class="">Add to Cart</button>
						<?php endif; ?>
					<?php else : ?>
						<p>login in to add product to cart</p>
					<?php endif; ?>
						</form>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-3">
			<div class="col-md-7 heading-section ftco-animate text-center">
				<span class="subheading">Discover</span>
				<h2 class="mb-4">Related products</h2>
				<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
			</div>
		</div>
		<div class="row">
			<?php foreach ($allReleatedProducts as $product) : ?>
				<div class="col-md-3">
					<div class="menu-entry">
						<a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $product->id; ?>" class="img" style="background-image: url(<?php echo APPURL; ?>/images/<?php echo $product->image; ?>);"></a>
						<div class="text text-center pt-4">
							<h3><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $product->id; ?>"><?php echo $product->name; ?></a></h3>
							<p><?php echo $product->description; ?></p>
							<p class="price"><span>$<?php echo $product->price; ?></span></p>
							<p><a href="<?php echo APPURL; ?>/products/product-single.php?id=<?php echo $product->id; ?>" class="btn btn-primary btn-outline-primary">Show</a></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php require '../includes/footer.php'; ?>