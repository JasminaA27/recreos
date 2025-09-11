<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-utensils"></i>
                    <h1>Recreos Huanta & Luricocha</h1>
                </div>
                <div class="user-info">
                    <div class="user-avatar"><?php echo substr($_SESSION['user_name'], 0, 1); ?></div>
                    <div>
                        <div><?php echo $_SESSION['user_name']; ?></div>
                        <small><?php echo $_SESSION['user_role']; ?></small>
                    </div>
                    <a href="index.php?controller=Auth&action=logout" class="btn btn-sm btn-danger" style="margin-left: 15px;">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>
    
    <div class="container">