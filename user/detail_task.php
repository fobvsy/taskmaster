<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];

if (!isset($_GET['id'])) {
    header("Location: tasks.php");
    exit();
}
$id_task = (int)$_GET['id'];

if (isset($_GET['action']) && $_GET['action'] === 'update_status' && isset($_GET['status'])) {
    $new_status = $_GET['status'];
    $valid_statuses = ['belum_dikerjakan', 'sedang_dikerjakan', 'selesai'];
    if (in_array($new_status, $valid_statuses)) {
        $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id_task = ? AND id_user = ?");
        $stmt->bind_param("sii", $new_status, $id_task, $id_user);
        $stmt->execute();
    }
    header("Location: detail_task.php?id=" . $id_task);
    exit();
}

$query = "SELECT tasks.*, categories.category_name FROM tasks LEFT JOIN categories ON tasks.id_category = categories.id_category WHERE tasks.id_task = $id_task AND tasks.id_user = $id_user";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: tasks.php");
    exit();
}

$task = mysqli_fetch_assoc($result);

// Formatting dates
$deadline = date('M d, Y', strtotime($task['deadline']));
$created_at = date('M d, Y', strtotime($task['created_at']));

// Format priority and status
$priorityText = ucfirst($task['priority']) . ' Priority';
$priorityClass = '';
if ($task['priority'] == 'tinggi') $priorityClass = 'bg-priority-high text-priority-high';
elseif ($task['priority'] == 'sedang') $priorityClass = 'bg-priority-medium text-priority-medium';
else $priorityClass = 'bg-priority-low text-priority-low';

$statusText = '';
$statusClass = '';
if ($task['status'] == 'belum_dikerjakan') {
    $statusText = 'To Do';
    $statusClass = 'bg-status-todo text-status-todo';
} elseif ($task['status'] == 'sedang_dikerjakan') {
    $statusText = 'In Progress';
    $statusClass = 'bg-primary text-primary';
} else {
    $statusText = 'Done';
    $statusClass = 'bg-status-done text-status-done';
}
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Task Detail</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                    "body-md": [
                            "Inter"
                    ],
                    "headline-lg": [
                            "Hanken Grotesk"
                    ],
                    "body-sm": [
                            "Inter"
                    ],
                    "label-sm": [
                            "Inter"
                    ],
                    "headline-lg-mobile": [
                            "Hanken Grotesk"
                    ],
                    "label-md": [
                            "Inter"
                    ],
                    "headline-md": [
                            "Hanken Grotesk"
            ]
            },
            "fontSize": {
                    "body-md": [
                            "16px",
                            {
                                    "lineHeight": "24px",
                                    "fontWeight": "400"
                            }
                    ],
                    "headline-lg": [
                            "30px",
                            {
                                    "lineHeight": "38px",
                                    "letterSpacing": "-0.02em",
                                    "fontWeight": "700"
                            }
                    ],
                    "body-sm": [
                            "14px",
                            {
                                    "lineHeight": "20px",
                                    "fontWeight": "400"
                            }
                    ],
                    "label-sm": [
                            "11px",
                            {
                                    "lineHeight": "14px",
                                    "fontWeight": "500"
                            }
                    ],
                    "headline-lg-mobile": [
                            "24px",
                            {
                                    "lineHeight": "32px",
                                    "letterSpacing": "-0.01em",
                                    "fontWeight": "700"
                            }
                    ],
                    "label-md": [
                            "12px",
                            {
                                    "lineHeight": "16px",
                                    "letterSpacing": "0.05em",
                                    "fontWeight": "600"
                            }
                    ],
                    "headline-md": [
                            "20px",
                            {
                                    "lineHeight": "28px",
                                    "fontWeight": "600"
                            }
                    ]
            }
    },
        },
      }
    </script>
<style>
        /* Custom Styles for Ambient Elevations */
        .ambient-shadow-base {
            box-shadow: 0px 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex">
<!-- SideNavBar (Desktop) -->
<nav class="hidden md:flex flex-col h-screen py-4 gap-2 bg-surface-container-low dark:bg-inverse-surface border-r border-outline-variant w-64 flex-shrink-0 sticky top-0 z-40">
<div class="px-4 py-6">
<a href="dashboard.php" class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary hover:opacity-80 transition-opacity block">TaskMaster</a>
</div>
<div class="px-4 mb-4">
<div class="flex items-center gap-3 mb-6">
<img class="w-10 h-10 rounded-full object-cover" data-alt="Profile" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlfK7BnBu3P29ljloYEHOBtSi4NCwgiDMGeQYsBGhP_rRcG9oOQBN562rq_ETF3SOhDKWCb4dhEZivL9jJiPHEKYGMTm0hnqW5DvPhYdqwJrppXtCRndhxAWGVZubmSEuO5NqNOoW6vBAdOZTdeanv1mvke1JG1prDLF0k10A8bZYHMIpJ5yQZysmbnspO4rtkx-d7SbPy9EgtDqxSIVJ5Ef9ZSKwVaCfoQ2qt2x68HaFOQ1xl2SF9WX2n8WuKEClgKyNpUz7TGno"/>
<div>
<div class="font-label-md text-label-md font-bold text-on-surface"><?= htmlspecialchars($nama) ?></div>
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
<main class="flex-1 flex flex-col min-h-screen">
<!-- Top Navigation Area for Task Actions (Task is a "dead end" relative to global nav, so we suppress BottomNavBar on mobile and just show contextual actions) -->
<header class="w-full px-margin-mobile md:px-margin-desktop py-4 max-w-container-max-width mx-auto flex justify-between items-center bg-surface sticky top-0 z-10 border-b border-border">
<a class="flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors font-label-md text-label-md group" href="tasks.php">
<span class="material-symbols-outlined" data-icon="arrow_back">arrow_back</span>
                Back to List
            </a>
<div class="flex items-center gap-4">
<a href="edit_task.php?id=<?= $id_task ?>" class="bg-transparent border border-border text-text-main hover:border-primary hover:text-primary px-4 py-2 rounded font-label-md text-label-md transition-colors">Edit</a>
<a href="delete_task.php?id=<?= $id_task ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');" class="bg-transparent text-error hover:bg-error-container px-4 py-2 rounded font-label-md text-label-md transition-colors">Delete</a>
</div>
</header>
<!-- Task Canvas -->
<div class="w-full px-margin-mobile md:px-margin-desktop py-8 max-w-container-max-width mx-auto flex-1">
<div class="bg-card-bg ambient-shadow-base rounded-xl border border-border p-6 md:p-8">
<!-- Metadata Header -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
<div class="flex items-center gap-2">
<!-- Status Badge -->
<span class="<?= $statusClass ?> bg-opacity-15 px-3 py-1 rounded-full font-label-sm text-label-sm uppercase tracking-wider flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]"><?= $task['status'] == 'selesai' ? 'done_all' : ($task['status'] == 'sedang_dikerjakan' ? 'incomplete_circle' : 'radio_button_unchecked') ?></span>
                            <?= $statusText ?>
                        </span>
<!-- Priority Badge -->
<span class="<?= $priorityClass ?> bg-opacity-15 px-3 py-1 rounded-full font-label-sm text-label-sm uppercase tracking-wider flex items-center gap-1">
<span class="material-symbols-outlined text-[14px]">flag</span>
                            <?= $priorityText ?>
                        </span>
</div>
<!-- Quick Status Action Buttons -->
<div class="flex items-center bg-surface-container-low rounded-lg p-1 border border-border shadow-sm">
    <a href="?id=<?= $id_task ?>&action=update_status&status=belum_dikerjakan" class="px-4 py-1.5 rounded-md font-label-sm text-label-sm transition-all duration-200 <?= $task['status'] == 'belum_dikerjakan' ? 'bg-surface shadow-[0_1px_2px_rgba(0,0,0,0.1)] text-on-surface font-bold border border-border' : 'text-on-surface-variant hover:text-on-surface hover:bg-surface-variant/30 border border-transparent' ?>">
        To Do
    </a>
    <a href="?id=<?= $id_task ?>&action=update_status&status=sedang_dikerjakan" class="px-4 py-1.5 rounded-md font-label-sm text-label-sm transition-all duration-200 <?= $task['status'] == 'sedang_dikerjakan' ? 'bg-surface shadow-[0_1px_2px_rgba(0,0,0,0.1)] text-primary font-bold border border-border' : 'text-on-surface-variant hover:text-primary hover:bg-primary/5 border border-transparent' ?>">
        In Progress
    </a>
    <a href="?id=<?= $id_task ?>&action=update_status&status=selesai" class="px-4 py-1.5 rounded-md font-label-sm text-label-sm transition-all duration-200 <?= $task['status'] == 'selesai' ? 'bg-surface shadow-[0_1px_2px_rgba(0,0,0,0.1)] text-status-done font-bold border border-border' : 'text-on-surface-variant hover:text-status-done hover:bg-status-done/5 border border-transparent' ?>">
        Done
    </a>
</div>
<div class="flex items-center gap-4 text-on-surface-variant font-label-sm text-label-sm">
<div class="flex items-center gap-1">
<span class="material-symbols-outlined text-[16px]">calendar_today</span>
                            Due: <?= $deadline ?>
                        </div>
<div class="flex items-center gap-1">
<span class="material-symbols-outlined text-[16px]">schedule</span>
                            Created: <?= $created_at ?>
                        </div>
</div>
</div>
<!-- Title -->
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-text-main mb-6">
    <?= htmlspecialchars($task['title']) ?>
</h1>
<!-- Category/Tags -->
<div class="flex items-center gap-2 mb-8">
<span class="material-symbols-outlined text-outline">sell</span>
<?php if ($task['category_name']): ?>
    <span class="bg-surface-container text-on-surface-variant px-2 py-1 rounded font-label-sm text-label-sm"><?= htmlspecialchars($task['category_name']) ?></span>
<?php else: ?>
    <span class="bg-surface-container text-on-surface-variant px-2 py-1 rounded font-label-sm text-label-sm">Uncategorized</span>
<?php endif; ?>
</div>
<!-- Description Area -->
<div class="prose prose-sm md:prose-base max-w-none text-on-surface font-body-md text-body-md border-t border-border pt-6 mb-8 whitespace-pre-wrap">
<?= htmlspecialchars($task['description']) ?>
</div>
<!-- Sub-tasks / Checklists Placeholder (Demonstrating Bento style arrangement if more content existed) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 border-t border-border pt-6">
<div class="bg-surface-bright p-4 rounded-lg border border-border">
<h3 class="font-label-md text-label-md text-text-main mb-3 flex items-center gap-2">
<span class="material-symbols-outlined">person</span>
                            Assignee
                        </h3>
<div class="flex items-center gap-3 font-body-sm text-body-sm">
<div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">
                                <?= strtoupper(substr($nama, 0, 1)) ?>
                            </div>
<span class="text-on-surface"><?= htmlspecialchars($nama) ?></span>
</div>
</div>
</div>
</div>
</div>
</main>
</body></html>







