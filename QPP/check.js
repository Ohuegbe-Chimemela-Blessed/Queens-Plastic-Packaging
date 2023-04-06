

		//creating random refrence
		// var reference = Math.random().toString().substring(2, 16);

		function generateReference() {
			const timestamp = new Date().toISOString().replace(/\D/g,'');
			const random = Math.floor(Math.random() * (999999 - 100000 + 1)) + 100000;
			return timestamp + '-' + random;
		  }
		// var form = document.querySelector('form');
		// form.addEventListener('submit', function(event) {
		// 	event.preventDefault();
		// 	payWithPaystack();
		// });

		function payWithPaystack() {
			const reference = generateReference();
			var handler = PaystackPop.setup({
				key: 'pk_test_235267f4e0d325e6cae9b60775d177f693f701b2', // Replace with your public key
				email: document.getElementById('email').value,
				amount: document.getElementById('total_price').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
				currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
				phone: document.getElementById('phone').value,
				Full_Name: document.getElementById('name').value,
				reference: reference,
				callback: function(response) {
					//this happens after the payment is completed successfully
					var reference = response.reference;
					window.location.href = "process-payment.php?reference=" + reference;
				},
				onClose: function() {
					alert('Transaction was not completed, window closed.');
				},
				onBankTransferConfirmationPending: function(){
					alert('Transaction confirmation ongoing, do not close.');
				}
			});
			handler.openIframe();
		}