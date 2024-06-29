
<?php require '../includes/header.php'; ?>
<?php require '../config/config.php'; ?>


<?php

	if(!isset($_SESSION['user_id'])){
		header('location: ' . APPURL . '');
	}

    if(!isset($_SERVER['HTTP_REFERER'])){
        header('location: http://localhost:8080/coffee-blend/index.php');
        exit;
    }

?>
<section class="home-slider owl-carousel">

	<div class="slider-item" style="background-image: url(<?php echo APPURL; ?>/images/bg_3.jpg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">

				<div class="col-md-7 col-sm-12 text-center ftco-animate">
					<h1 class="mb-3 mt-5 bread">Pay with Paypal</h1>
					<p class="breadcrumbs"><span class="mr-2"><a href="<?php echo APPURL; ?>">Home</a></span> <span>Pay with Paypal</span></p>
				</div>

			</div>
		</div>
	</div>
</section>
<div class="container">  
                <!-- Replace "test" with your own sandbox Business account app client ID -->
                <script src="https://www.paypal.com/sdk/js?client-id=AQMMe25tdpkD-E0duygFfFerha0bg3dODikErDpPMM9Ss6EniHTKZ4nzUeMVOcCP0O_Avvh0KxDOiGI3&currency=USD"></script>
                <!-- Set up a container element for the button -->
                <div id="paypal-button-container"></div>
                <script>
                    paypal.Buttons({
                    // Sets up the transaction when a payment button is clicked
                    createOrder: (data, actions) => {
                        return actions.order.create({
                        purchase_units: [{
                            amount: {
                            value: '<?php echo $_SESSION["total_price"]; ?>' // Can also reference a variable or function
                            }
                        }]
                        });
                    },
                    // Finalize the transaction after payer approval
                    onApprove: (data, actions) => {
                        return actions.order.capture().then(function(orderData) {
                      
                         window.location.href='delete-cart.php';
                        });
                    }
                    }).render('#paypal-button-container');
                </script>
              
            </div>

<?php require '../includes/footer.php'; ?>
