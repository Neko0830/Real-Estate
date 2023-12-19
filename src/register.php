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
    <link rel="stylesheet" href="../dist/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- User Registration Form -->
    <div class='container w-96 m-auto mt-4'>
        <div class="tabs space-x-6">
            <?php foreach ($tabs as $index => $tab) : ?>
                <button class="tab tab-lifted btn <?= $activeTab == $index ? 'tab-active' : '' ?>" onclick="setActiveTab(<?= $index ?>)"><?= $tab ?></button>
            <?php endforeach; ?>
        </div>

        <div class="flex justify-center items-center shadow-lg" id="userTab" <?= $activeTab != 0 ? 'style="display: none;"' : '' ?>>
            <div class='card w-96'>
                <h2 class='card-title text-lg font-semibold'>User Registration</h2>
                <form action="user_registration.php" method="POST">
                    <label for="fullname">Full Name:</label><br>
                    <input class="border border-gray-400 py-1 px-2 w-full" type="text" id="fullname" name="fullname" required><br><br>

                    <label for="username">Username:</label><br>
                    <input class="border border-gray-400 py-1 px-2 w-full" type="text" id="username" name="username" required><br><br>

                    <label for="email">Email:</label><br>
                    <input class="border border-gray-400 py-1 px-2 w-full" type="email" id="email" name="email" required><br><br>

                    <label for="contact">Phone Number:</label><br>
                    <input class="border border-gray-400 py-1 px-2 w-full" type="text" id="contact" name="contact" required><br><br>


                    <label for="password">Password:</label><br>
                    <input class="border border-gray-400 py-1 px-2 w-full" type="password" id="password" name="password" required><br><br>

                    <input  class="btn btn-accent btn-outline w-full" type="submit" value="Register">
                </form>
            </div>
        </div>
    </div>
    <!-- Owner Registration Form -->
    <div class="flex justify-center items-center shadow-lg">
        <div class="card w-96" id="ownerTab" <?= $activeTab != 1 ? 'style="display: none;"' : '' ?>>
            <h2 class='text-lg font-semibold'>Owner Registration</h2>
            <form action="owner_registration.php" method="POST">
                <label for="ownerFullName">Full Name:</label><br>
                <input class="border border-gray-400 py-1 px-2 w-full" type="text" id="ownerFullName" name="ownerFullName" required><br><br>

                <label for="ownerUserName">Username:</label><br>
                <input class="border border-gray-400 py-1 px-2 w-full" type="text" id="ownerUserName" name="ownerUserName" required><br><br>

                <label for="ownerEmail">Email:</label><br>
                <input class="border border-gray-400 py-1 px-2 w-full" type="email" id="ownerEmail" name="ownerEmail" required><br><br>

                <label for="contact">Phone Number:</label><br>
                <input class="border border-gray-400 py-1 px-2 w-full" type="text" id="contact" name="contact" required><br><br>

                <label for="ownerPassword">Password:</label><br>
                <input class="border border-gray-400 py-1 px-2 w-full" type="password" id="ownerPassword" name="ownerPassword" required><br><br>

                <input class="btn btn-accent btn-outline w-full" type="submit" value="Register">
            </form>
        </div>
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