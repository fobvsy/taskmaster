<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

$where = "WHERE tasks.id_user = $id_user";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where .= " AND (tasks.title LIKE '%$search%' OR tasks.description LIKE '%$search%')";
}

$query = "SELECT tasks.*, categories.category_name FROM tasks LEFT JOIN categories ON tasks.id_category = categories.id_category $where ORDER BY tasks.deadline ASC";
$result = mysqli_query($conn, $query);

$tasks_todo = [];
$tasks_progress = [];
$tasks_done = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] == 'belum_dikerjakan') {
            $tasks_todo[] = $row;
        } elseif ($row['status'] == 'sedang_dikerjakan') {
            $tasks_progress[] = $row;
        } elseif ($row['status'] == 'selesai') {
            $tasks_done[] = $row;
        }
    }
}

// Function to generate task card
function renderTaskCard($task) {
    $priorityClass = '';
    $priorityIcon = '';
    if ($task['priority'] == 'tinggi') {
        $priorityClass = 'bg-priority-high/10 text-priority-high';
        $priorityIcon = '<span class="material-symbols-outlined text-[12px] fill-current" style="font-variation-settings: \'FILL\' 1;">error</span>';
    } elseif ($task['priority'] == 'sedang') {
        $priorityClass = 'bg-priority-medium/10 text-priority-medium';
    } else {
        $priorityClass = 'bg-priority-low/10 text-priority-low';
    }
    
    $categoryName = $task['category_name'] ? htmlspecialchars($task['category_name']) : 'No Category';
    $catBg = 'bg-secondary-fixed text-on-secondary-fixed';
    
    $opacity = $task['status'] == 'selesai' ? 'opacity-70' : '';
    $lineThrough = $task['status'] == 'selesai' ? 'line-through decoration-outline-variant' : '';
    $doneIcon = $task['status'] == 'selesai' ? '<span class="material-symbols-outlined text-[16px]">done_all</span>' : '<span class="material-symbols-outlined text-[16px]">schedule</span>';
    $doneTextClass = $task['status'] == 'selesai' ? 'text-status-done' : 'text-deadline-warning'; 
    
    $dateText = date('M d', strtotime($task['deadline']));
    
    $html = '<div class="task-card bg-card-bg rounded-DEFAULT border border-border p-gutter flex flex-col gap-3 cursor-grab relative group" onclick="window.location.href=\'detail_task.php?id='.$task['id_task'].'\'">';
    if ($task['status'] == 'selesai') {
        $html .= '<div class="absolute inset-0 bg-white/40 z-10 pointer-events-none rounded-DEFAULT"></div>';
    }
    
    $html .= '<div class="flex justify-between items-start '.$opacity.'">';
    $html .= '<span class="'.$catBg.' font-label-sm text-label-sm px-2 py-1 rounded-DEFAULT">'.$categoryName.'</span>';
    $html .= '<span class="'.$priorityClass.' font-label-sm text-label-sm px-2 py-1 rounded-DEFAULT flex items-center gap-1">'.$priorityIcon.ucfirst($task['priority']).'</span>';
    $html .= '</div>';
    
    $html .= '<div class="'.$opacity.'">';
    $html .= '<h3 class="font-body-md text-body-md font-semibold text-text-main mb-1 '.$lineThrough.'">'.htmlspecialchars($task['title']).'</h3>';
    $html .= '<p class="font-body-sm text-body-sm text-on-surface-variant line-clamp-2">'.htmlspecialchars($task['description']).'</p>';
    $html .= '</div>';
    
    $html .= '<div class="flex items-center justify-between mt-2 pt-3 border-t border-surface-container '.$opacity.'">';
    $html .= '<div class="flex items-center gap-3 text-on-surface-variant font-label-sm text-label-sm">';
    $html .= '<div class="flex items-center gap-1 '.$doneTextClass.'">';
    $html .= $doneIcon;
    $html .= $dateText;
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>'; 
    
    $html .= '</div>'; 
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Daftar Tugas</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
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
                        "body-md": ["Inter", "sans-serif"],
                        "headline-lg": ["Hanken Grotesk", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"],
                        "headline-lg-mobile": ["Hanken Grotesk", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        "headline-md": ["Hanken Grotesk", "sans-serif"]
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
        /* Hide scrollbar for clean horizontal scrolling */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Card hover elevation */
        .task-card {
            box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }
        .task-card:hover {
            box-shadow: 0px 4px 12px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-surface text-on-surface flex h-screen overflow-hidden font-body-md">
<!-- SideNavBar (Desktop) -->
<nav class="hidden md:flex flex-col h-screen py-4 gap-2 bg-surface-container-low dark:bg-inverse-surface border-r border-outline-variant w-64 flex-shrink-0 sticky top-0">
<div class="px-4 py-6">
<a href="dashboard.php" class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary hover:opacity-80 transition-opacity block">TaskMaster</a>
</div>
<div class="px-4 mb-4">
<div class="flex items-center gap-3 mb-6">
<img class="w-10 h-10 rounded-full object-cover" data-alt="Profile" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlfK7BnBu3P29ljloYEHOBtSi4NCwgiDMGeQYsBGhP_rRcG9oOQBN562rq_ETF3SOhDKWCb4dhEZivL9jJiPHEKYGMTm0hnqW5DvPhYdqwJrppXtCRndhxAWGVZubmSEuO5NqNOoW6vBAdOZTdeanv1mvke1JG1prDLF0k10A8bZYHMIpJ5yQZysmbnspO4rtkx-d7SbPy9EgtDqxSIVJ5Ef9ZSKwVaCfoQ2qt2x68HaFOQ1xl2SF9WX2n8WuKEClgKyNpUz7TGno"/>
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
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="dashboard.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="dashboard">dashboard</span>
<span class="font-label-md text-label-md">Dashboard</span>
</a>
<!-- Active Tab -->
<a class="flex items-center gap-3 bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary rounded-lg px-4 py-3 mx-2 translate-x-1 duration-200 group" href="tasks.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="view_kanban">view_kanban</span>
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
<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full w-full min-w-0 bg-background relative z-0">
<!-- Top App Bar / Header -->
<header class="w-full px-margin-mobile md:px-margin-desktop py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-background z-10 sticky top-0">
<div>
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-text-main">Daftar Tugas</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Manage and track your ongoing projects.</p>
</div>
<form method="GET" action="tasks.php" class="flex items-center gap-3 w-full md:w-auto">
<div class="relative flex-1 md:w-64">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
<input name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" class="w-full h-10 pl-10 pr-4 bg-surface-container-lowest border border-border rounded-lg font-body-sm text-body-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="Search tasks..." type="text"/>
</div>
<button type="button" class="h-10 px-4 bg-surface-container-lowest border border-border rounded-lg flex items-center gap-2 font-label-md text-label-md text-text-main hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Filter
                </button>
<button type="submit" class="hidden">Submit</button>
</form>
</header>
<!-- Board Area (Horizontal Scroll) -->
<div class="flex-1 overflow-x-auto overflow-y-hidden no-scrollbar px-margin-mobile md:px-margin-desktop pb-6 pt-2">
<div class="flex gap-6 h-full items-start min-w-max">
<!-- Column: Todo -->
<div class="w-[320px] max-h-full flex flex-col bg-surface-container rounded-xl flex-shrink-0">
<div class="p-4 flex items-center justify-between sticky top-0 bg-surface-container z-10 rounded-t-xl border-b border-border/50">
<div class="flex items-center gap-2">
<h2 class="font-headline-md text-headline-md text-text-main">To Do</h2>
<span class="bg-surface-variant text-on-surface-variant font-label-sm text-label-sm px-2 py-0.5 rounded-full"><?= count($tasks_todo) ?></span>
</div>
<button class="text-on-surface-variant hover:text-primary transition-colors">
<span class="material-symbols-outlined">more_horiz</span>
</button>
</div>
<div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 no-scrollbar">
<?php foreach ($tasks_todo as $task) echo renderTaskCard($task); ?>
<!-- Add Task Button -->
<button class="w-full py-3 rounded-DEFAULT border-2 border-dashed border-outline-variant text-on-surface-variant font-label-md text-label-md hover:border-primary hover:text-primary hover:bg-primary-fixed/20 transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-[18px]">add</span>
                            Add Task
                        </button>
</div>
</div>
<!-- Column: In Progress -->
<div class="w-[320px] max-h-full flex flex-col bg-surface-container rounded-xl flex-shrink-0">
<div class="p-4 flex items-center justify-between sticky top-0 bg-surface-container z-10 rounded-t-xl border-b border-border/50">
<div class="flex items-center gap-2">
<h2 class="font-headline-md text-headline-md text-text-main flex items-center gap-2">
<span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                In Progress
                            </h2>
<span class="bg-surface-variant text-on-surface-variant font-label-sm text-label-sm px-2 py-0.5 rounded-full"><?= count($tasks_progress) ?></span>
</div>
<button class="text-on-surface-variant hover:text-primary transition-colors">
<span class="material-symbols-outlined">more_horiz</span>
</button>
</div>
<div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 no-scrollbar">
<?php foreach ($tasks_progress as $task) echo renderTaskCard($task); ?>
</div>
</div>
<!-- Column: Done -->
<div class="w-[320px] max-h-full flex flex-col bg-surface-container rounded-xl flex-shrink-0 opacity-80 hover:opacity-100 transition-opacity">
<div class="p-4 flex items-center justify-between sticky top-0 bg-surface-container z-10 rounded-t-xl border-b border-border/50">
<div class="flex items-center gap-2 text-status-done">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<h2 class="font-headline-md text-headline-md text-text-main">Done</h2>
<span class="bg-surface-variant text-on-surface-variant font-label-sm text-label-sm px-2 py-0.5 rounded-full ml-1"><?= count($tasks_done) ?></span>
</div>
<button class="text-on-surface-variant hover:text-primary transition-colors">
<span class="material-symbols-outlined">more_horiz</span>
</button>
</div>
<div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4 no-scrollbar">
<?php foreach ($tasks_done as $task) echo renderTaskCard($task); ?>
</div>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 bg-surface border-t border-outline-variant shadow-md rounded-t-xl">
<a class="flex flex-col items-center justify-center text-on-surface-variant active:bg-surface-container-highest tap:scale-90 duration-150 p-2 rounded-lg group" href="dashboard.php">
<span class="material-symbols-outlined">home</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Home</span>
</a>
<!-- Active State: Tasks -->
<a class="flex flex-col items-center justify-center text-primary font-bold active:bg-surface-container-highest tap:scale-90 duration-150 p-2 rounded-lg group" href="tasks.php">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">list_alt</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Tasks</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant active:bg-surface-container-highest tap:scale-90 duration-150 p-2 rounded-lg -mt-6 group" href="add_task.php">
<div class="bg-primary text-on-primary w-12 h-12 rounded-full flex items-center justify-center shadow-lg">
<span class="material-symbols-outlined text-[28px]">add</span>
</div>
<span class="font-label-sm text-label-sm-mobile mt-1">Add</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant active:bg-surface-container-highest tap:scale-90 duration-150 p-2 rounded-lg group" href="#">
<span class="material-symbols-outlined">person</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Profile</span>
</a>
</nav>
</body></html>




