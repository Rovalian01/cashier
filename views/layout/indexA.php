<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="dashboard">
        <?php include __DIR__ . '/../templates/sidebar.php'; ?>

        <?php include __DIR__ . '/../../routes/web.php'; ?>
    </div>

    <script src="js/invoice-rendering.js"></script>
</body>
</html>

