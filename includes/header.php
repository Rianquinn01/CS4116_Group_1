<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Load notification functions if the user is logged in
if (isset($_SESSION['logged_in']) && isset($_SESSION['user_id'])) {
    require_once __DIR__ . '/notification_functions.php';
    $unread_notification_count = getUnreadNotificationCount($pdo, $_SESSION['user_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduCoach</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #2c3e50;
        }
        .nav-link {
            font-weight: 500;
        }
        .btn-messages {
            border-radius: 50px;
            padding: 0.375rem 1rem;
        }
        .btn-login {
            border-radius: 4px;
            font-weight: 500;
        }
        .hero-section {
            background-color: #f8f9fa;
            padding: 4rem 0;
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
        }
        .hero-text {
            font-size: 1.1rem;
            color: #6c757d;
        }
        .category-card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            text-align: center;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }
        .category-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto;
        }
        .category-title {
            margin-top: 1rem;
            font-weight: 600;
        }
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            font-weight: 500;
            position: relative;
            width: auto;
            overflow: visible;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 8px;
            object-fit: cover;
        }
        .dropdown-menu .dropdown-item {
            clear: both;
            white-space: nowrap;
            display: block;
        }
        /* Ensure all dropdown elements have proper z-index and pointer events */
        .dropdown, .dropdown-menu, .dropdown-toggle {
            z-index: 1050 !important;
        }
        
        /* Fix pointer events for dropdown triggers and content */
        .dropdown-toggle, .dropdown-menu, .dropdown-item, .nav-link {
            pointer-events: auto !important;
        }
        
        /* Ensure proper stacking for navbar elements */
        .navbar, .navbar-nav, .navbar-collapse {
            z-index: 1050 !important;
            position: relative;
        }
        
        /* Prevent event blocking on dropdowns */
        .dropdown-menu.show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary" href="home.php">EduCoach</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'home.php' ? 'active' : '' ?>" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $current_page === 'coach-search.php' ? 'active' : '' ?>" href="coach-search.php">Find Coaches</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="coach-search.php?sort_by=rating_desc">Highest Rated</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="coach-search.php?category=1">Mathematics</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=2">Languages</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=3">Sciences</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=4">Arts</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=5">Computer Science</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=6">Test Preparation</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=7">Business</a></li>
                            <li><a class="dropdown-item" href="coach-search.php?category=8">Humanities</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="help.php">Help Center</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['logged_in'])): ?>
                        <li class="nav-item">
                            <a class="nav-link position-relative <?= $current_page === 'notifications.php' ? 'active' : '' ?>" href="notifications.php">
                                <i class="bi bi-bell"></i>
                                <?php if (isset($unread_notification_count) && $unread_notification_count > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $unread_notification_count > 99 ? '99+' : $unread_notification_count ?>
                                    <span class="visually-hidden">unread notifications</span>
                                </span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page === 'messages.php' ? 'active' : '' ?>" href="messages.php">
                                <i class="bi bi-chat-dots"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle"></i>
                                <?= $_SESSION['username'] ?? 'Account' ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                                <li><a class="dropdown-item" href="session.php">My Sessions</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page === 'login.php' ? 'active' : '' ?>" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current_page === 'register.php' ? 'active' : '' ?>" href="register.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="become-coach.php">Become a Coach</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <?php
    // Remove the problematic code that assumes $user is defined
    // Session variables are already set in auth_functions.php when the user logs in
    ?> 
    <!-- Load the necessary JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Fix for dropdown functionality -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix dropdown functionality
        const dropdownToggleElements = document.querySelectorAll('.dropdown-toggle');
        
        dropdownToggleElements.forEach(function(element) {
            // Remove any existing event listeners first
            const newElement = element.cloneNode(true);
            element.parentNode.replaceChild(newElement, element);
            
            // Add fresh event listener
            newElement.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Toggle dropdown visibility
                const dropdownMenu = this.nextElementSibling;
                if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
                    const isActive = dropdownMenu.classList.contains('show');
                    
                    // Close all other dropdowns first
                    document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                        menu.classList.remove('show');
                    });
                    
                    // Toggle current dropdown
                    if (!isActive) {
                        dropdownMenu.classList.add('show');
                        // Ensure proper positioning
                        dropdownMenu.style.position = 'absolute';
                        dropdownMenu.style.inset = '0px auto auto 0px';
                        dropdownMenu.style.transform = 'translate(0px, 40px)';
                    }
                }
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                    menu.classList.remove('show');
                });
            }
        });
        
        // Prevent closing dropdowns when clicking inside them
        document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
            menu.addEventListener('click', function(e) {
                if (e.target.tagName !== 'A') {
                    e.stopPropagation();
                }
            });
        });
    });
    </script>
</body>
</html> 