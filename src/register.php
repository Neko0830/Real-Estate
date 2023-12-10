<?php
    $tabs = [
        "Register as User",
        "Register as Owner",
    ];
    $activeTab = 0; // Start with the User registration form
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tabbed Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Define your styles here */
        /* For instance: */
        /* .hidden { display: none; } */
    </style>
</head>
<body>
    <div class="tabs">
        <?php foreach ($tabs as $index => $tab): ?>
            <button class="tab tab-lifted <?= $activeTab == $index ? 'tab-active' : '' ?>" onclick="setActiveTab(<?= $index ?>)"><?= $tab ?></button>
        <?php endforeach; ?>
    </div>

    <!-- User Registration Form -->
    <div class="card" id="userTab" <?= $activeTab != 0 ? 'style="display: none;"' : '' ?>>
        <h2>User Registration</h2>
        <form action="user_registration.php" method="POST">
            <label for="fullname">Fullname:</label><br>
            <input type="text" id="fullname" name="fullname" required><br><br>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="contact">Phone Number:</label><br>
            <input type="text" id="contact" name="contact" required><br><br>


            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <input class="btn btn-accent btn-outline" type="submit" value="Register">
        </form>
    </div>

    <!-- Owner Registration Form -->
    <div class="card" id="ownerTab" <?= $activeTab != 1 ? 'style="display: none;"' : '' ?>>
        <h2>Owner Registration</h2>
        <form action="owner_registration.php" method="POST">
            <label for="ownerFullName">Full Name:</label><br>
            <input type="text" id="ownerFullName" name="ownerFullName" required><br><br>
            
            <label for="ownerUserName">Username:</label><br>
            <input type="text" id="ownerUserName" name="ownerUserName" required><br><br>

            <label for="ownerEmail">Email:</label><br>
            <input type="email" id="ownerEmail" name="ownerEmail" required><br><br>
            
            <label for="contact">Phone Number:</label><br>
            <input type="text" id="contact" name="contact" required><br><br>

            <label for="ownerPassword">Password:</label><br>
            <input type="password" id="ownerPassword" name="ownerPassword" required><br><br>

            <input class="btn btn-accent btn-outline" type="submit" value="Register">
        </form>
    </div>

    <script>
        function setActiveTab(tabIndex) {
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('tab-active');
            });
            document.querySelector(`.tab:nth-child(${tabIndex + 1})`).classList.add('tab-active');

            document.getElementById('userTab').style.display = 'none';
            document.getElementById('ownerTab').style.display = 'none';

            if (tabIndex === 0) {
                document.getElementById('userTab').style.display = 'block';
            } else if (tabIndex === 1) {
                document.getElementById('ownerTab').style.display = 'block';
            }
        }
    </script>
</body>
</html>
