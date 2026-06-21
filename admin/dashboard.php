<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

// Get Total Users
$qUsers = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$totalUsers = mysqli_fetch_assoc($qUsers)['total'];

// Get Active Users
$qActiveUsers = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user' AND status = 'aktif'");
$activeUsers = mysqli_fetch_assoc($qActiveUsers)['total'];

// Get Total Categories
$qCategories = mysqli_query($conn, "SELECT COUNT(*) as total FROM categories");
$totalCategories = mysqli_fetch_assoc($qCategories)['total'];

// Get Recent Registrations
$qRecent = mysqli_query($conn, "SELECT nama, email, created_at FROM users WHERE role = 'user' ORDER BY created_at DESC LIMIT 4");
$recentUsers = [];
if ($qRecent) {
    while ($row = mysqli_fetch_assoc($qRecent)) {
        $recentUsers[] = $row;
    }
}

// Helper for time ago
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'h',
        'i' => 'm',
        's' => 's',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . $v;
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-on-surface": "#eff1f3",
                        "inverse-primary": "#c3c0ff",
                        "primary-fixed-dim": "#c3c0ff",
                        "surface-bright": "#f7f9fb",
                        "surface-container-lowest": "#ffffff",
                        "outline-variant": "#c7c4d8",
                        "surface-tint": "#4d44e3",
                        "priority-high": "#EF4444",
                        "secondary-fixed": "#d3e4fe",
                        "secondary-fixed-dim": "#b7c8e1",
                        "on-error": "#ffffff",
                        "status-todo": "#94A3B8",
                        "border": "#E2E8F0",
                        "on-tertiary-fixed": "#001a42",
                        "tertiary-fixed-dim": "#adc6ff",
                        "error": "#ba1a1a",
                        "surface": "#f7f9fb",
                        "on-secondary-fixed": "#0b1c30",
                        "on-surface-variant": "#464555",
                        "card-bg": "#FFFFFF",
                        "primary-fixed": "#e2dfff",
                        "tertiary": "#004598",
                        "on-secondary-container": "#54647a",
                        "on-tertiary-container": "#cedbff",
                        "secondary-container": "#d0e1fb",
                        "on-tertiary-fixed-variant": "#004395",
                        "priority-low": "#22C55E",
                        "surface-container-low": "#f2f4f6",
                        "on-secondary-fixed-variant": "#38485d",
                        "status-done": "#16A34A",
                        "on-primary-container": "#dad7ff",
                        "tertiary-container": "#005cc6",
                        "outline": "#777587",
                        "error-container": "#ffdad6",
                        "surface-container-high": "#e6e8ea",
                        "primary": "#3525cd",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "tertiary-fixed": "#d8e2ff",
                        "priority-medium": "#F59E0B",
                        "on-primary-fixed-variant": "#3323cc",
                        "on-background": "#191c1e",
                        "on-secondary": "#ffffff",
                        "surface-container-highest": "#e0e3e5",
                        "on-error-container": "#93000a",
                        "primary-container": "#4f46e5",
                        "on-tertiary": "#ffffff",
                        "deadline-warning": "#FB923C",
                        "secondary": "#505f76",
                        "background": "#f7f9fb",
                        "on-primary-fixed": "#0f0069",
                        "on-surface": "#191c1e",
                        "on-primary": "#ffffff",
                        "surface-container": "#eceef0",
                        "surface-variant": "#e0e3e5",
                        "text-main": "#1E293B"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "unit": "4px",
                        "gutter": "16px",
                        "margin-mobile": "16px",
                        "container-max-width": "1440px",
                        "margin-desktop": "32px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "headline-lg": ["Hanken Grotesk"],
                        "body-sm": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-lg-mobile": ["Hanken Grotesk"],
                        "label-md": ["Inter"],
                        "headline-md": ["Hanken Grotesk"]
                    },
                    "fontSize": {
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-sm": ["11px", { "lineHeight": "14px", "fontWeight": "500" }],
                        "headline-lg-mobile": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex text-body-md overflow-x-hidden">
<!-- SideNavBar -->
<aside class="hidden md:flex flex-col h-screen py-4 gap-2 bg-surface-container-low dark:bg-inverse-surface border-r border-outline-variant fixed left-0 w-64 z-40">
<div class="px-4 py-6">
<h1 class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">Project Space</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant">Team Workspace</p>
</div>

<nav class="flex-1 flex flex-col gap-1 mt-4">
<a class="flex items-center gap-3 bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary rounded-lg px-4 py-3 mx-2 translate-x-1 duration-200 group" href="dashboard.php">
<span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="dashboard">dashboard</span>
<span class="font-label-md text-label-md">Dashboard</span>
</a>

<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="categories.php">
<span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="category">category</span>
<span class="font-label-md text-label-md">Categories</span>
</a>
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="users.php">
<span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="group">group</span>
<span class="font-label-md text-label-md">Users</span>
</a>
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="#">
<span class="material-symbols-outlined group-hover:rotate-90 transition-transform duration-300" data-icon="settings">settings</span>
<span class="font-label-md text-label-md">Settings</span>
</a>
</nav>
<div class="mt-auto flex flex-col gap-1 mb-4">
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="#">
<span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="help">help</span>
<span class="font-label-md text-label-md">Help</span>
</a>
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="../auth/logout.php">
<span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform duration-300" data-icon="logout">logout</span>
<span class="font-label-md text-label-md">Logout</span>
</a>
</div>
</aside>
<!-- Main Content -->
<main class="flex-1 md:ml-64 p-margin-mobile md:p-margin-desktop min-h-screen">
<header class="flex justify-between items-center mb-8">
<div>
<h2 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">System Overview</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-1">Real-time metrics and system health.</p>
</div>
<div class="flex items-center gap-4">
<div class="relative hidden sm:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
<input class="h-10 pl-10 pr-4 rounded-full border border-border bg-surface focus:ring-2 focus:ring-primary-container focus:border-transparent font-body-sm text-body-sm w-64 outline-none" placeholder="Search..." type="text"/>
</div>
<div class="w-10 h-10 rounded-full bg-surface-container-high overflow-hidden border border-border">
<img alt="User Avatar" class="w-full h-full object-cover" data-alt="A professional headshot of a person looking forward, neutral lighting, corporate minimalist style, sharp focus, slate blue background." src="https://lh3.googleusercontent.com/aida-public/AB6AXuD6rowihmmJNBThhtRLtnlUyxifLJB3NRMGxZMWHFWQvjEX8yJF2HD3EAUkTAs24ETda2s6VPmfQYqtlWUYsGC3iXt_AkO3oLqNAMeT65rVWKCiKUY5NyRC4HdqkWIz9Ddiv-kVQz5mgGYsXshGXu9lJy2UkovDPdtCwwwH_ffS8FSgMXgwyfWK41R_ECkc629pj7BRP2tkcyT0dA3NeRKom4FV_PU0u-vX1fIEYXX4a-F39o4COh-SxaqjlgnhBqADjl2KAKA-OB4"/>
</div>
</div>
</header>
<!-- Bento Grid Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter mb-gutter">
<!-- Total Users Card -->
<div class="bg-card-bg rounded-xl p-gutter border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden group">
<div class="absolute inset-0 bg-gradient-to-br from-primary-fixed/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
<div class="flex justify-between items-start z-10">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">Total Users</p>
<h3 class="font-headline-lg text-headline-lg text-on-surface mt-1"><?= number_format($totalUsers) ?></h3>
</div>
<div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
<span class="material-symbols-outlined text-[20px]" data-icon="group">group</span>
</div>
</div>
<div class="flex items-center gap-1 z-10 text-status-done font-label-sm text-label-sm">
<span class="material-symbols-outlined text-[14px]">arrow_upward</span>
<span>12% from last month</span>
</div>
</div>
<!-- Active Users Card -->
<div class="bg-card-bg rounded-xl p-gutter border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden group">
<div class="absolute inset-0 bg-gradient-to-br from-priority-low/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
<div class="flex justify-between items-start z-10">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">Active Users</p>
<h3 class="font-headline-lg text-headline-lg text-on-surface mt-1"><?= number_format($activeUsers) ?></h3>
</div>
<div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-priority-low">
<span class="material-symbols-outlined text-[20px]" data-icon="how_to_reg">how_to_reg</span>
</div>
</div>
<div class="flex items-center gap-1 z-10 text-status-done font-label-sm text-label-sm">
<span class="material-symbols-outlined text-[14px]">arrow_upward</span>
<span>5.4% from yesterday</span>
</div>
</div>
<!-- Total Categories -->
<div class="bg-card-bg rounded-xl p-gutter border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden group">
<div class="absolute inset-0 bg-gradient-to-br from-priority-medium/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
<div class="flex justify-between items-start z-10">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">Total Categories</p>
<h3 class="font-headline-lg text-headline-lg text-on-surface mt-1"><?= number_format($totalCategories) ?></h3>
</div>
<div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-priority-medium">
<span class="material-symbols-outlined text-[20px]" data-icon="category">category</span>
</div>
</div>
<div class="flex items-center gap-1 z-10 text-on-surface-variant font-label-sm text-label-sm">
<span>Stable</span>
</div>
</div>
<!-- System Status -->
<div class="bg-card-bg rounded-xl p-gutter border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden group">
<div class="absolute inset-0 bg-gradient-to-br from-tertiary-container/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
<div class="flex justify-between items-start z-10">
<div>
<p class="font-label-md text-label-md text-on-surface-variant">System Status</p>
<h3 class="font-headline-md text-headline-md text-status-done mt-2">Optimal</h3>
</div>
<div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-status-done">
<span class="material-symbols-outlined text-[20px]" data-icon="check_circle">check_circle</span>
</div>
</div>
<div class="flex items-center gap-1 z-10 text-on-surface-variant font-label-sm text-label-sm">
<span>Uptime: 99.99%</span>
</div>
</div>
</div>
<!-- Main Content Area: Charts & Tables -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-gutter">
<!-- Activity Chart Placeholder -->
<div class="lg:col-span-2 bg-card-bg rounded-xl p-gutter border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-md text-headline-md text-on-surface">User Activity Trend</h3>
<select class="border-none bg-surface-container-low text-on-surface-variant rounded-md font-body-sm text-body-sm px-3 py-1 outline-none">
<option>Last 7 Days</option>
<option>Last 30 Days</option>
<option>This Year</option>
</select>
</div>
<!-- Chart Area Placeholder (Visual only) -->
<div class="h-64 w-full relative flex items-end justify-between gap-2 px-2">
<!-- Simple CSS bar chart visualization -->
<div class="w-full bg-primary-container rounded-t-sm h-[40%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Mon</div>
</div>
<div class="w-full bg-primary-container rounded-t-sm h-[60%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Tue</div>
</div>
<div class="w-full bg-primary-container rounded-t-sm h-[30%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Wed</div>
</div>
<div class="w-full bg-primary-container rounded-t-sm h-[80%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Thu</div>
</div>
<div class="w-full bg-primary-container rounded-t-sm h-[50%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Fri</div>
</div>
<div class="w-full bg-secondary-container rounded-t-sm h-[20%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Sat</div>
</div>
<div class="w-full bg-secondary-container rounded-t-sm h-[15%] hover:opacity-80 transition-opacity relative group">
<div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-inverse-surface text-inverse-on-surface text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">Sun</div>
</div>
</div>
</div>
<!-- Recent Registrations List -->
<div class="bg-card-bg rounded-xl p-gutter border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)] flex flex-col">
<div class="flex justify-between items-center mb-6">
<h3 class="font-headline-md text-headline-md text-on-surface">Recent Registrations</h3>
<a href="users.php" class="text-primary font-label-sm text-label-sm hover:underline">View All</a>
</div>
<div class="flex flex-col gap-4 flex-1">
<?php if(empty($recentUsers)): ?>
    <p class="text-on-surface-variant text-sm">Belum ada user yang terdaftar.</p>
<?php else: ?>
    <?php foreach($recentUsers as $ru): 
        $initials = strtoupper(substr($ru['nama'], 0, 1));
    ?>
    <div class="flex items-center justify-between group">
    <div class="flex items-center gap-3">
    <div class="w-10 h-10 rounded-full bg-surface-container-high border border-border overflow-hidden flex items-center justify-center text-primary font-bold text-lg">
        <?= $initials ?>
    </div>
    <div>
    <p class="font-label-md text-label-md text-on-surface"><?= htmlspecialchars($ru['nama']) ?></p>
    <p class="font-body-sm text-body-sm text-on-surface-variant"><?= htmlspecialchars($ru['email']) ?></p>
    </div>
    </div>
    <span class="font-label-sm text-label-sm text-on-surface-variant group-hover:text-primary transition-colors"><?= time_elapsed_string($ru['created_at']) ?></span>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 bg-surface dark:bg-inverse-surface shadow-lg border-t border-outline-variant dark:border-outline rounded-t-xl">
<a class="flex flex-col items-center justify-center text-primary dark:text-inverse-primary font-bold active:bg-surface-container-highest p-2 rounded-lg group" href="dashboard.php">
<span class="material-symbols-outlined mb-1 group-hover:scale-110 transition-transform duration-300" data-icon="home">home</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Home</span>
</a>


<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="users.php">
<span class="material-symbols-outlined mb-1 group-hover:scale-110 transition-transform duration-300" data-icon="group">group</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Users</span>
</a>
</nav>
</body></html>
