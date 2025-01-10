      <?php $user = current_user(); ?>
      <!DOCTYPE html>
      <html lang="en">

      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php if (!empty($page_title))
        echo remove_junk($page_title);
        elseif (!empty($user))
          echo ucfirst($user['name']);
        else echo "Inventory Management System"; ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/main.css">
      </head>

      <body>
        <?php if ($session->isUserLoggedIn(true)): ?>
          <div id="wrapper">
            <header class="site__header">
              <div class="site__logo">
                <a href="admin.php"><span class="logo_bold">IMS</span></a>
              </div>
              <div class="site__header-frame">
                <div class="profile-dropdown">
                  <div onclick="toggle()" class="profile-dropdown-btn">
                    <div class="profile-img">
                      <img src="uploads/users/<?php echo !empty($user['image']) ? $user['image'] : 'default.jpg'; ?>" alt="Profile Image" />
                    </div>
                  </div>
                  <ul class="profile-dropdown-list">
                    <li class="profile-dropdown-list-item">
                      <a href="edit_user.php?id=<?php echo (int)$user['id']; ?>">
                        <i class="icon-user"></i>
                        Profile
                      </a>
                    </li>
                    <li class="profile-dropdown-list-item">
                      <a href="edit_account.php" title="edit account">
                        <i class="icon-settings"></i>
                        Settings
                      </a>
                    </li>
                    <hr />
                    <li class="profile-dropdown-list-item">
                      <a href="logout.php">
                        <i class="icon-logout"></i>
                        Log out
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </header>
            <main id="site__main" class="site__main">
              <div class="sidebar worksidebar">
                <?php if ($user['user_level'] === '1'): ?>
                  <!-- admin menu -->
                  <?php include_once('admin_menu.php'); ?>
                <?php elseif ($user['user_level'] === '2'): ?>
                  <!-- Special user -->
                  <?php include_once('special_menu.php'); ?>

                <?php elseif ($user['user_level'] === '3'): ?>
                  <!-- User menu -->
                  <?php include_once('user_menu.php'); ?>

                <?php endif; ?>

              </div>
            <?php endif; ?>

            <section class="workboard">