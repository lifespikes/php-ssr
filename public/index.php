<?php

require_once '../vendor/autoload.php';

?>

<!doctype html>
<html lang="en">
<head>
    <title>PHP-SSR</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php echo (new LifeSpikes\SSRExample\App())->boot(); ?>
</body>
</html>
