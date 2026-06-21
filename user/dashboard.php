<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

// Get statistics
$queryTotal = "SELECT COUNT(*) as total FROM tasks WHERE id_user = $id_user";
$totalTasks = mysqli_fetch_assoc(mysqli_query($conn, $queryTotal))['total'];

$queryInProgress = "SELECT COUNT(*) as total FROM tasks WHERE id_user = $id_user AND status = 'sedang_dikerjakan'";
$inProgressTasks = mysqli_fetch_assoc(mysqli_query($conn, $queryInProgress))['total'];

$queryCompleted = "SELECT COUNT(*) as total FROM tasks WHERE id_user = $id_user AND status = 'selesai'";
$completedTasks = mysqli_fetch_assoc(mysqli_query($conn, $queryCompleted))['total'];

$queryHighPriority = "SELECT COUNT(*) as total FROM tasks WHERE id_user = $id_user AND priority = 'tinggi'";
$highPriorityTasks = mysqli_fetch_assoc(mysqli_query($conn, $queryHighPriority))['total'];

$queryNearDeadline = "SELECT COUNT(*) as total FROM tasks WHERE id_user = $id_user AND status != 'selesai' AND deadline BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)";
$nearDeadlineTasks = mysqli_fetch_assoc(mysqli_query($conn, $queryNearDeadline))['total'];

// Get Upcoming Tasks
$queryUpcoming = "SELECT * FROM tasks WHERE id_user = $id_user AND status != 'selesai' ORDER BY deadline ASC LIMIT 3";
$resUpcoming = mysqli_query($conn, $queryUpcoming);
$upcomingTasks = [];
if ($resUpcoming) {
    while ($row = mysqli_fetch_assoc($resUpcoming)) {
        $upcomingTasks[] = $row;
    }
}

// Get Recent Activity
$queryActivity = "SELECT * FROM tasks WHERE id_user = $id_user ORDER BY updated_at DESC LIMIT 3";
$resActivity = mysqli_query($conn, $queryActivity);
$recentActivities = [];
if ($resActivity) {
    while ($row = mysqli_fetch_assoc($resActivity)) {
        $recentActivities[] = $row;
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Dashboard</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex">
<!-- SideNavBar (Desktop) -->
<nav class="hidden md:flex flex-col h-screen py-4 gap-2 bg-surface-container-low dark:bg-inverse-surface border-r border-outline-variant w-64 flex-shrink-0 sticky top-0">
<div class="px-4 py-6">
<a href="dashboard.php" class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary hover:opacity-80 transition-opacity block">TaskMaster</a>
</div>
<div class="px-4 mb-4">
<div class="flex items-center gap-3 mb-6">
<img class="w-10 h-10 rounded-full object-cover" data-alt="A small, professional profile portrait of a confident person smiling subtly. The lighting is soft and studio-quality, set against a light, neutral background that fits seamlessly into a modern corporate UI. The image exudes competence and approachability, suitable for a productivity app avatar." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlfK7BnBu3P29ljloYEHOBtSi4NCwgiDMGeQYsBGhP_rRcG9oOQBN562rq_ETF3SOhDKWCb4dhEZivL9jJiPHEKYGMTm0hnqW5DvPhYdqwJrppXtCRndhxAWGVZubmSEuO5NqNOoW6vBAdOZTdeanv1mvke1JG1prDLF0k10A8bZYHMIpJ5yQZysmbnspO4rtkx-d7SbPy9EgtDqxSIVJ5Ef9ZSKwVaCfoQ2qt2x68HaFOQ1xl2SF9WX2n8WuKEClgKyNpUz7TGno"/>
<div>
<div class="font-label-md text-label-md font-bold"><?= htmlspecialchars($nama) ?></div>
<div class="font-body-sm text-body-sm text-on-surface-variant">User Dashboard</div>
</div>
</div>
<a href="add_task.php" class="w-full bg-primary-container text-on-primary text-white font-label-md py-2 rounded flex items-center justify-center gap-2 hover:bg-primary hover:-translate-y-0.5 hover:shadow-md transition-all duration-300">
<span class="material-symbols-outlined">add</span>
                New Task</a>
</div>
<div class="flex-1 overflow-y-auto">
<!-- Active Tab -->
<a class="flex items-center gap-3 bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary rounded-lg px-4 py-3 mx-2 translate-x-1 duration-200 group" href="dashboard.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="dashboard">dashboard</span>
<span class="font-label-md text-label-md">Dashboard</span>
</a>
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="tasks.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="view_kanban">view_kanban</span>
<span class="font-label-md text-label-md">Tasks</span>
</a>

<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="#"><span class="material-symbols-outlined group-hover:rotate-90 transition-transform duration-300" data-icon="settings">settings</span>
<span class="font-label-md text-label-md">Settings</span>
</a>
</div>
<div class="mt-auto border-t border-outline-variant pt-4">
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="#"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="help">help</span>
<span class="font-label-md text-label-md">Help</span>
</a>
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="../auth/login.php"><span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform duration-300" data-icon="logout">logout</span>
<span class="font-label-md text-label-md">Logout</span>
</a>
</div>
</nav>
<!-- Main Content Canvas -->
<main class="flex-1 flex flex-col min-w-0 bg-surface">
<!-- Top App Bar (Mobile) -->
<header class="md:hidden flex justify-between items-center w-full px-margin-mobile py-4 bg-surface border-b border-outline-variant sticky top-0 z-40">
<a href="dashboard.php" class="font-headline-md text-headline-md font-bold text-primary hover:opacity-80 transition-opacity block">TaskMaster</a>
<button class="text-on-surface-variant">
<span class="material-symbols-outlined">menu</span>
</button>
</header>
<div class="flex-1 overflow-y-auto p-margin-mobile md:p-margin-desktop">
<div class="max-w-container-max-width mx-auto space-y-8">
<header class="mb-8">
<h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Dashboard Overview</h2>
<p class="font-body-md text-body-md text-on-surface-variant mt-2">Here's what's happening with your projects today.</p>
</header>
<!-- Summary Stats (Bento Grid) -->
<section class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-gutter">
<!-- Total Tasks -->
<div class="bg-card-bg p-4 rounded-xl border border-border shadow-[0_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden">
<div class="flex justify-between items-start">
<span class="font-label-md text-label-md text-on-surface-variant">Total Tasks</span>
<span class="material-symbols-outlined text-outline">checklist</span>
</div>
<div>
<span class="font-headline-lg text-headline-lg text-on-surface block"><?= $totalTasks ?></span>
</div>
</div>
<!-- In Progress -->
<div class="bg-card-bg p-4 rounded-xl border border-border shadow-[0_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden">
<div class="flex justify-between items-start">
<span class="font-label-md text-label-md text-on-surface-variant">In Progress</span>
<span class="material-symbols-outlined text-primary">trending_up</span>
</div>
<div>
<span class="font-headline-lg text-headline-lg text-on-surface block"><?= $inProgressTasks ?></span>
</div>
<div class="absolute bottom-0 left-0 h-1 bg-primary w-1/3"></div>
</div>
<!-- Completed -->
<div class="bg-card-bg p-4 rounded-xl border border-border shadow-[0_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden">
<div class="flex justify-between items-start">
<span class="font-label-md text-label-md text-on-surface-variant">Completed</span>
<span class="material-symbols-outlined text-status-done">check_circle</span>
</div>
<div>
<span class="font-headline-lg text-headline-lg text-on-surface block"><?= $completedTasks ?></span>
</div>
<div class="absolute bottom-0 left-0 h-1 bg-status-done w-1/2"></div>
</div>
<!-- High Priority -->
<div class="bg-card-bg p-4 rounded-xl border border-border shadow-[0_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden col-span-2 md:col-span-1 lg:col-span-1">
<div class="flex justify-between items-start">
<span class="font-label-md text-label-md text-on-surface-variant">High Priority</span>
<span class="material-symbols-outlined text-priority-high">warning</span>
</div>
<div>
<span class="font-headline-lg text-headline-lg text-on-surface block"><?= $highPriorityTasks ?></span>
</div>
<div class="absolute bottom-0 left-0 h-1 bg-priority-high w-full"></div>
</div>
<!-- Near Deadline -->
<div class="bg-card-bg p-4 rounded-xl border border-border shadow-[0_1px_3px_rgba(0,0,0,0.1)] flex flex-col justify-between h-32 relative overflow-hidden col-span-2 md:col-span-2 lg:col-span-1">
<div class="flex justify-between items-start">
<span class="font-label-md text-label-md text-on-surface-variant">Near Deadline</span>
<span class="material-symbols-outlined text-deadline-warning">schedule</span>
</div>
<div>
<span class="font-headline-lg text-headline-lg text-on-surface block"><?= $nearDeadlineTasks ?></span>
</div>
<div class="absolute bottom-0 left-0 h-1 bg-deadline-warning w-3/4"></div>
</div>
</section>
<!-- Two Column Layout for Main Content Area -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
<!-- Quick View List (2/3 width) -->
<section class="lg:col-span-2 space-y-4">
<div class="flex justify-between items-center mb-4">
<h3 class="font-headline-md text-headline-md text-on-surface">Upcoming Tasks</h3>
<button class="font-label-md text-label-md text-primary hover:underline">View All</button>
</div>
<!-- Task List -->
<div class="space-y-3">
<?php if (count($upcomingTasks) > 0): ?>
    <?php foreach ($upcomingTasks as $task): ?>
        <?php 
            $priorityClass = '';
            if ($task['priority'] == 'tinggi') $priorityClass = 'bg-priority-high/10 text-priority-high';
            elseif ($task['priority'] == 'sedang') $priorityClass = 'bg-priority-medium/10 text-priority-medium';
            else $priorityClass = 'bg-priority-low/10 text-priority-low';
            
            $icon = $task['status'] == 'sedang_dikerjakan' ? 'incomplete_circle' : 'radio_button_unchecked';
        ?>
        <div class="bg-card-bg border border-border rounded-lg p-4 shadow-[0_1px_3px_rgba(0,0,0,0.1)] hover:shadow-md transition-shadow cursor-pointer flex gap-4 items-start" onclick="window.location.href='detail_task.php?id=<?= $task['id_task'] ?>'">
        <div class="mt-1">
        <span class="material-symbols-outlined text-outline hover:text-primary transition-colors"><?= $icon ?></span>
        </div>
        <div class="flex-1">
        <div class="flex justify-between items-start mb-1">
        <h4 class="font-body-md text-body-md font-semibold text-on-surface"><?= htmlspecialchars($task['title']) ?></h4>
        <span class="inline-block px-2 py-1 rounded <?= $priorityClass ?> font-label-sm text-label-sm"><?= ucfirst($task['priority']) ?></span>
        </div>
        <p class="font-body-sm text-body-sm text-on-surface-variant mb-3 line-clamp-2"><?= htmlspecialchars($task['description']) ?></p>
        <div class="flex items-center gap-4 text-on-surface-variant">
        <div class="flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">calendar_today</span>
        <span class="font-label-sm text-label-sm"><?= date('M d, Y', strtotime($task['deadline'])) ?></span>
        </div>
        </div>
        </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-center text-on-surface-variant py-4">Tidak ada tugas terdekat.</div>
<?php endif; ?>
</div>
</section>
<!-- Sidebar Content (1/3 width) -->
<aside class="space-y-6">
<!-- Activity Feed Minimal -->
<div class="bg-surface-container-low rounded-xl p-6 border border-border">
<h3 class="font-headline-md text-headline-md text-on-surface mb-4">Recent Activity</h3>
<div class="space-y-4">
<?php if (count($recentActivities) > 0): ?>
    <?php foreach ($recentActivities as $activity): ?>
        <?php
            $icon = 'edit';
            $bg = 'bg-surface-variant';
            $textClass = 'text-on-surface-variant';
            $action = 'updated';
            
            if ($activity['status'] == 'selesai') {
                $icon = 'done';
                $bg = 'bg-secondary-container';
                $textClass = 'text-on-secondary-container';
                $action = 'completed';
            } elseif ($activity['created_at'] == $activity['updated_at']) {
                $icon = 'add';
                $bg = 'bg-primary-container';
                $textClass = 'text-on-primary';
                $action = 'created';
            }
        ?>
        <div class="flex gap-3">
        <div class="w-8 h-8 rounded-full <?= $bg ?> flex items-center justify-center <?= $textClass ?> flex-shrink-0">
        <span class="material-symbols-outlined text-[18px]"><?= $icon ?></span>
        </div>
        <div>
        <p class="font-body-sm text-body-sm text-on-surface"><span class="font-semibold">You</span> <?= $action ?> <em><?= htmlspecialchars($activity['title']) ?></em></p>
        <span class="font-label-sm text-label-sm text-on-surface-variant"><?= date('M d, H:i', strtotime($activity['updated_at'])) ?></span>
        </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="text-on-surface-variant text-sm">Belum ada aktivitas.</div>
<?php endif; ?>
</div>
</div>
</aside>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 bg-surface dark:bg-inverse-surface shadow-lg border-t border-outline-variant dark:border-outline rounded-t-xl">
<a class="flex flex-col items-center justify-center text-primary dark:text-inverse-primary font-bold active:bg-surface-container-highest scale-90 duration-150 p-2 rounded-lg group" href="dashboard.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="home">home</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Home</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="tasks.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="list_alt">list_alt</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Tasks</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="add_task.php"><span class="material-symbols-outlined group-hover:rotate-90 transition-transform duration-300" data-icon="add_circle">add_circle</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Add</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="#"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="person">person</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Profile</span>
</a>
</nav>
</body></html>




