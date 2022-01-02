<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <?php echo Asset::css('style.css'); ?>
    <?php echo Asset::js('scr.js') ?>
    <?php echo Asset::js('validator.js') ?>
    <title><?php echo $title?></title>
    
    
</head>
<body>
    
    <?php echo $content ?>

    
</body>
</html>