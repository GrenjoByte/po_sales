<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="<?php echo base_url();?>darken/shader.js"></script>
    <title>Login — Saki Mart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bs-tertiary-bg);
        }
        .login-card {
            width: 100%;
            max-width: 380px;
            border: none;
            border-radius: 16px;
        }
        .brand-title {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.08em;
        }
        :root {
		    --bs-primary: #0F6E56;
		    --bs-primary-rgb: 15, 110, 86;
		    --bs-btn-bg: #0F6E56;
		    --bs-btn-border-color: #0F6E56;
		    --bs-btn-hover-bg: #0a5240;
		    --bs-btn-hover-border-color: #0a5240;
		    --bs-link-color: #0F6E56;
		}

		.text-primary {
		    color: #0F6E56 !important;
		}

		.btn-primary {
		    background-color: #0F6E56;
		    border-color: #0F6E56;
		}

		.btn-primary:hover {
		    background-color: #0a5240;
		    border-color: #0a5240;
		}

		.input-group-text {
		    border-color: #dee2e6;
		}

		.form-control:focus {
		    border-color: #0F6E56;
		    box-shadow: 0 0 0 0.2rem rgba(15, 110, 86, 0.15);
		}

		.brand-title {
		    font-size: 1.8rem;
		    font-weight: 700;
		    letter-spacing: 2px;
		}
    </style>
</head>
<body>
    <header>
        <?php include 'esses/assets.php';?>
    </header>
    <main class="w-100 px-3">
        <div class="card shadow-sm p-4 pt-5 pb-5 login-card mx-auto">

            <!-- Brand -->
            <div class="text-center mb-4">
                <div class="brand-title text-primary mb-1">SAKI MART</div>
                <h5 class="fw-semibold mb-0">Welcome back</h5>
                <p class="text-muted small mb-0">Sign in to continue</p>
            </div>

            <form novalidate id="login_form">
                <div class="mb-3">
                    <label class="form-label small fw-semibold" for="username">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-body border-end-0">
                            <i class="bi bi-person text-muted" style="font-size:14px;"></i>
                        </span>
                        <input id="username" name="username" type="text"
                            class="form-control border-start-0 shadow-none"
                            placeholder="Enter username"
                            autocomplete="username">
                    </div>
                </div>
                <div class="mb-4">
				    <label class="form-label small fw-semibold" for="password">Password</label>
				    <div class="input-group">
				        <span class="input-group-text bg-body border-end-0">
				            <i class="bi bi-lock text-muted" style="font-size:14px;"></i>
				        </span>
				        <input id="password" name="password" type="password"
				            class="form-control border-start-0 border-end-0 shadow-none"
				            placeholder="Enter password"
				            autocomplete="current-password">
				        <span class="input-group-text bg-body border-start-0" id="toggle_password" style="cursor:pointer;">
				            <i class="bi bi-eye text-muted" style="font-size:14px;"></i>
				        </span>
				    </div>
				</div>
                <button type="button" class="btn btn-primary w-100 rounded-pill" id="login_button">
                    Sign In
                </button>
            </form>
        </div>
        <p class="text-center text-muted small mt-3">Saki Mart POS &copy; <?php echo date('Y'); ?></p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script type="text/javascript">
	$('#login_button').on('click', function() {
		attempt_login();
	})
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('login_button').click();
        }
    });

    document.getElementById('toggle_password').addEventListener('click', function () {
        let input = document.getElementById('password');
        let icon  = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
	function attempt_login() {
		var ajax = $.ajax({
			method: 'POST',
			url   : '<?php echo base_url();?>i.php/sys_control/attempt_login',
			data  : new FormData($('#login_form')[0]),
			contentType: false,
			cache: false,
			processData: false
		});
		var jqxhr = ajax
			.done(function() {
				var response = JSON.parse(jqxhr.responseText);
		
				var status = response.status;
				var user_type = response.user_type;
				var last_name = response.last_name;
				var gender = response.gender;

				if (status == 'success') {
					if (user_type == 1) {
						page = 'inventory';
					}
					else if (user_type == 2) {
						page = 'sales';
					}
					else if (user_type == 8) {
						page = 'inventory';
					}
					else {
						alert("Unknown error. Please call the developer and refrain from using the system.");
						return;
					}

					if (gender == 'male') {
						address_text = 'Mr. '+last_name;
					}
					else if (gender == 'female') {
						address_text = 'Ms. '+last_name;
					}	
					else {
						address_text = last_name.UCwords();
					}
					var address_element = `
					    <span class="text-success fw-semibold">
					        ${address_text}
					    </span>
					`;

					title = "Login Successful";
					message = `Welcome ${address_element}! Please wait while we redirect you to your page.`;	
					status = "success";
					load_notification(title, message, status);
					setTimeout(function(){
				  		window.location.replace('<?php echo base_url();?>i.php/sys_control/'+page);
				  	}, 2500);
				}
				else if (status == 'inactive') {
				    title = "Account Disabled";
				    message = "Your account has been deactivated. Please contact the administrator.";
				    status = "error";
				    load_notification(title, message, status);
				}
				else if (status == 'error') {
					status = "error";
				    title = "Login Failed";
				    message = "Invalid username or password.";
				    status = "error";
				    load_notification(title, message, status);
				}
			})
			.fail(function() {
				alert("error");
			})
			.always(function() {
				
			})
		;
	}
</script>
</html>