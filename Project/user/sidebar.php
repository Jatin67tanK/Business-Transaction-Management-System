<head>
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="./css/sidebar.css">
</head>
<?php include "./session_init.php"; ?>

<style>
  /* Sidebar Base */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #0f172a;
    color: #fff;
    position: fixed;
    top: 0;
    left: 0;
    padding-top: 10px;
    transition: width 0.3s ease-in-out;
    overflow: hidden;
}


/* Sidebar Header */
.sidebar .head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 15px;
}

.sidebar .logo {
    font-size: 1.4rem;
    font-weight: bold;
    transition: opacity 0.3s ease-in-out;
}


        .sidebar.hidden~.dashboard {
            margin-left: 60px;
        }

.hide{
    display: none;
}
/* Menu Items */
.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar ul li {
    position: relative;
}

.sidebar ul li a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: white;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    transition: background 0.3s, font-size 0.3s;
}

.sidebar ul li a:hover {
    background: #1e293b;
}

/* Collapsed Sidebar */
.sidebar.hidden {
    width: 60px;
}

/* Hide logo on collapse */
.sidebar.hidden .logo {
    opacity: 0;
    pointer-events: none;
}

/* Collapse links - only show icons */
.sidebar.hidden ul li a {
    justify-content: center;
    padding: 12px 0;
}

/* Hide text but keep icons */
.sidebar.hidden ul li a span {
    display: none;
}

/* Ensure icons are always visible */
.sidebar ul li a i {
    font-size: 18px;
    min-width: 20px;
    text-align: center;
}

/* Tooltip on hover when collapsed */
.sidebar.hidden ul li a::after {
    content: attr(data-title);
    position: absolute;
    left: 65px;
    top: 50%;
    transform: translateY(-50%);
    background: #111827;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s ease-in-out, transform 0.25s ease-in-out;
    font-size: 14px;
}

.sidebar.hidden ul li a:hover::after {
    opacity: 1;
    transform: translateY(-50%) translateX(5px);
}

/* Profile Section */
.profile-section {
    width: 100%;
    margin-top: auto;
}

.profile-section a {
    height: 50px;
    width: 100%;
    text-decoration: none;
    color: white;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
}

.profile-section a .profile-image img {
    height: 40px;
    width: 40px;
    border-radius: 50%;
}

.profile-section a .pro-details {
    flex: 1;
}

.sidebar.hidden .profile-section .pro-details {
    display: none; /* hide username on collapse */
}

.profile-section a:hover {
    background-color: #1e293b;
}


/* Responsive Sidebar */

@media (max-width: 768px) {
    
  .sidebar {
        width: 100%;
        height: 100vh;
        position: absolute;
        z-index: 1;
    }

    .dashboard {
        margin-left: 0;
    }

    .sidebar.hidden {
        width: 0;
    }

        .sidebar.hidden~.dashboard {
            margin-left: 00px;
        }

  
}

@media (max-width: 576px) {
  .add-category {
    flex-direction: column;
  }
.sidebar.hidden~.dashboard {
        margin-left: 0px;
    }
  /* .dashboard {
        margin-left: 00px;
    } */

  .category-item {
    flex-direction: column;
    align-items: flex-start;
  }

  .category-item input {
    width: 100%;
  }
  .category-item .delete{
    width: 100%;
  }

  .form-container {
    padding: 15px;
  }
}

</style>
<div class="sidebar" id="sidebar">
  <div class="head">
    </a><div class="logo">⚡ CashFlowX</div>
    <!-- <div class="hamburger" id="hamburger">&#9776;</div> -->
  </div>

  <ul class="menu">
  <li><a href="./user_dashboard.php" data-title="Dashboard"><i class="fa-solid fa-house"></i><span> Dashboard</span></a></li>
  <li><a href="../insertTransaction.php" data-title="Add Transaction"><i class="fa-solid fa-plus"></i><span> Add Transaction</span></a></li>
  <!-- <li><a href="./user_managment.php" data-title="User Manager"><i class="fa-solid fa-users"></i><span> User Manager</span></a></li> -->
</ul>

  <div class="profile-section">
    <a href="./profile.php">
      <div class="profile-image">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User">
      </div>
      <div class="pro-details">
        <?php echo "<p>".$_SESSION['username']."</p>" ?>
      </div>
    </a>
  </div>
</div>

<!-- <script src="./js/script.js"></script> -->
