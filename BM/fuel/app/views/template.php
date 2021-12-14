<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    
    <?php echo Asset::css('style.css'); ?>
    <?php echo Asset::js('scr.js') ?>
    <title><?php echo $title?></title>
    
    
</head>
<body>
    
    <?php echo $content ?>

    
</body>
</html>