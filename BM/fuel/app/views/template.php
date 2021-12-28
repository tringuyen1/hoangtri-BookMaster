<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
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