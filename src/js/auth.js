// js 
document.addEventListener('DOMContentLoaded', function(e) {

	const showAuthButton = document.getElementById('nsp-show-auth-form'),
	      authContainer = document.getElementById('nsp-auth-container'),
	       close = document.getElementById('nsp-auth-close'),
	       authForm = document.getElementById('nsp-auth-form'),
	       status = authForm.querySelector('[data-message="status"]');

	showAuthButton.addEventListener('click' , () => {
		authContainer.classList.add('show');
		showAuthButton.parentElement.classList.add('hide');
	});

	close.addEventListener('click' , () => {
		authContainer.classList.remove('show');
		showAuthButton.parentElement.classList.remove('hide');
	});

	authForm.addEventListener('submit' , e => {
		console.log("submit");
		e.preventDefault();

		// reset the form messages
		resetMessages();

		// collect form datas

		let data = {
			name: authForm.querySelector('[name="username"]').value,
			password: authForm.querySelector('[name="password"]').value,
			nonce: authForm.querySelector('[name="nsp_auth"]').value,
		}

		//validate
		if(!data.name || !data.password) {
			status.innerHTML = "Missing Datas";
			status.classList.add('error');
			return;
		}
		

		let url = authForm.dataset.url;
		let params = new URLSearchParams(new FormData(authForm));

		authForm.querySelector('[name="submit"]').value = 'Logging in ...';
		authForm.querySelector('[name="submit"]').disabled = true;



		fetch(url , {
			method: "POST",
			body: params
		}).then(res => res.json())

			.catch(error => {
				resetMessages();
			})
			.then(response => {
				resetMessages();
				if(response == 0 || !response.status) {
					status.innerHTML = response.message;
					status.classList.add('error');
					return;
				}

				status.innerHTML = response.message;
				status.classList.add('success');
				authForm.reset();

				window.location.reload();
			})


	})

	function resetMessages() {
		// reset all the mesages
		status.innerHTML = '';
		status.classList.remove('success' , 'error');

		authForm.querySelector('[name="submit"]').value = "Login";
		authForm.querySelector('[name="submit"]').disabled = false;
	}

})