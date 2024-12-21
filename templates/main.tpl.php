<?php
/**
 * /templates/main.tpl.php
 *
 * @package Radio Contacts
 * @version 0.0.1
 */

// Include configuration file
include_once("include/config.php");


session_start(); // Start a session to access messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= htmlspecialchars($config['app_name'], ENT_QUOTES, 'UTF-8'); ?></title>

    <!-- Latest Bootstrap and FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: url('img/background.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .frame {
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 20px;
            color: white;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            outline: none;
            color: white;
        }

        label {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        .btn {
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .is-valid {
            border-color: green;
        }

        .is-invalid {
            border-color: red;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #ccc;
        }
        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            border-radius: 10px;
        }
        .alert {
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const usernameInput = document.getElementById("username-signup");
            const emailInput = document.getElementById("email-signup");
            const signupForm = document.querySelector("#signup form");

            // Function to display or hide error messages
            const displayError = (input, message) => {
                const errorContainer = input.nextElementSibling;
                if (message) {
                    errorContainer.textContent = message;
                    input.classList.add("is-invalid");
                    input.classList.remove("is-valid");
                } else {
                    errorContainer.textContent = "";
                    input.classList.add("is-valid");
                    input.classList.remove("is-invalid");
                }
            };

            // Function to check username and email availability
            const checkAvailability = (field, value, callback) => {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "include/validate_user.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = () => {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        callback(response);
                    }
                };

                xhr.send(`field=${field}&value=${encodeURIComponent(value)}`);
            };

            // Event listener for username input
            usernameInput.addEventListener("blur", () => {
                const username = usernameInput.value.trim();
                if (username) {
                    checkAvailability("username", username, (response) => {
                        if (response.status === "taken") {
                            displayError(usernameInput, response.message);
                        } else {
                            displayError(usernameInput, "");
                        }
                    });
                }
            });

            // Event listener for email input
            emailInput.addEventListener("blur", () => {
                const email = emailInput.value.trim();
                if (email) {
                    checkAvailability("email", email, (response) => {
                        if (response.status === "taken") {
                            displayError(emailInput, response.message);
                        } else {
                            displayError(emailInput, "");
                        }
                    });
                }
            });

            // Form validation before submission
            signupForm.addEventListener("submit", (e) => {
                const username = usernameInput.value.trim();
                const email = emailInput.value.trim();
                const password = document.getElementById("password-signup").value.trim();

                if (!username || !email || !password) {
                    alert("All fields are required.");
                    e.preventDefault();
                    return;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert("Please enter a valid email address.");
                    e.preventDefault();
                }

                if (document.querySelectorAll(".is-invalid").length > 0) {
                    alert("Please fix the errors before submitting.");
                    e.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
        <!-- Show success message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); // Remove the message after displaying it ?>
        <?php endif; ?>

        <div class="frame">
            <div class="text-center mb-4">
                <div class="logo">
                    <!-- Placeholder for logo -->
                </div>
            </div>

            <ul class="nav nav-pills justify-content-center mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="signin-tab" data-bs-toggle="pill" data-bs-target="#signin" type="button" role="tab" aria-controls="signin" aria-selected="true">Existing User</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="signup-tab" data-bs-toggle="pill" data-bs-target="#signup" type="button" role="tab" aria-controls="signup" aria-selected="false">New User</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <!-- Sign In Form -->
                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                    <form action="<?= htmlspecialchars($baseURL, ENT_QUOTES, 'UTF-8'); ?>/user/login" method="POST">
                        <div class="mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autocomplete="username">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="remember-me">
                            <label class="form-check-label" for="remember-me">Keep me signed in</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <div class="text-center mt-3 forgot">
                            <a href="#">Forgot your password?</a>
                        </div>
                    </form>
                </div>

                <!-- Sign Up Form -->
                <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="username-signup">Username</label>
                            <input type="text" class="form-control" id="username-signup" name="username" placeholder="Enter your username" autocomplete="username">
                            <div class="error-message"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email-signup">Email</label>
                            <input type="email" class="form-control" id="email-signup" name="email" placeholder="Enter your email" autocomplete="email">
                            <div class="error-message"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password-signup">Create Password</label>
                            <input type="password" class="form-control" id="password-signup" name="password" placeholder="Create a password" autocomplete="new-password">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Sign Up</button>
                    </form>
                </div>
            </div>

            <div class="footer">
                &copy; 2024 Nitestryker Software
            </div>
        </div>
    </div>

    <!-- Latest Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
