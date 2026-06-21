<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$error = '';

$categories = [];
$catQuery = "SELECT * FROM categories";
$catResult = mysqli_query($conn, $catQuery);
if ($catResult) {
    while ($row = mysqli_fetch_assoc($catResult)) {
        $categories[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['task-title'] ?? '');
    $description = mysqli_real_escape_string($conn, $_POST['task-desc'] ?? '');
    $id_category = mysqli_real_escape_string($conn, $_POST['task-category'] ?? '');
    $priority = mysqli_real_escape_string($conn, $_POST['priority'] ?? 'rendah');
    $deadline = mysqli_real_escape_string($conn, $_POST['task-deadline'] ?? '');
    
    if ($priority == 'low') $priority = 'rendah';
    elseif ($priority == 'medium') $priority = 'sedang';
    elseif ($priority == 'high') $priority = 'tinggi';
    
    if (empty($title) || empty($deadline)) {
        $error = "Title dan Deadline wajib diisi.";
    } else {
        $category_val = empty($id_category) ? 'NULL' : "'$id_category'";
        
        $query = "INSERT INTO tasks (id_user, id_category, title, description, priority, deadline, status, created_at, updated_at) 
                  VALUES ($id_user, $category_val, '$title', '$description', '$priority', '$deadline', 'belum_dikerjakan', NOW(), NOW())";
                  
        if (mysqli_query($conn, $query)) {
            header("Location: tasks.php?msg=success");
            exit();
        } else {
            $error = "Gagal menambahkan tugas: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html class="h-full" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Add Task</title>
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
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-lg": ["30px", {"lineHeight": "38px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                        "label-sm": ["11px", {"lineHeight": "14px", "fontWeight": "500"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "700"}],
                        "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "headline-md": ["20px", {"lineHeight": "28px", "fontWeight": "600"}]
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
<body class="bg-background text-on-background font-body-md min-h-screen flex">

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
<main class="flex-1 h-full overflow-y-auto bg-surface-bright pb-24 md:pb-0 relative">
<div class="max-w-container-max-width mx-auto px-margin-mobile md:px-margin-desktop py-8 md:py-12">
<div class="mb-8">
<button class="text-on-surface-variant flex items-center gap-1 font-label-md text-label-md hover:text-primary transition-colors mb-4">
<span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    Back to Tasks
                </button>
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">Create New Task</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Define the details, priority, and deadline for your next objective.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Main Form Form -->
<div class="lg:col-span-2">
<div class="bg-card-bg rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.1)] border border-border p-6 md:p-8 relative overflow-hidden">
<!-- Subtle decorative background element -->
<div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
<form method="POST" action="" class="space-y-6 relative z-10">
<?php if ($error): ?>
    <div class="bg-error-container text-on-error-container p-3 rounded-lg font-body-sm text-body-sm">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<!-- Title -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="task-title">Task Title</label>
<input required class="w-full h-[40px] px-4 bg-surface rounded-lg border border-border text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder:text-outline placeholder:font-body-sm placeholder:text-body-sm" id="task-title" name="task-title" placeholder="e.g., Update Marketing Presentation" type="text"/>
</div>
<!-- Description -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="task-desc">Description</label>
<textarea class="w-full p-4 bg-surface rounded-lg border border-border text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-y placeholder:text-outline placeholder:font-body-sm placeholder:text-body-sm" id="task-desc" name="task-desc" placeholder="Provide context and necessary details for this task..." rows="4"></textarea>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- Category -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="task-category">Category</label>
<div class="relative">
<select class="w-full h-[40px] px-4 appearance-none bg-surface rounded-lg border border-border text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer" id="task-category" name="task-category">
<option disabled="" selected="" value="">Select a category</option>
<?php foreach ($categories as $cat): ?>
    <option value="<?= $cat['id_category'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
<?php endforeach; ?>
</select>
<div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-on-surface-variant">
<span class="material-symbols-outlined text-[20px]">expand_more</span>
</div>
</div>
</div>
<!-- Priority -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2">Priority Level</label>
<div class="flex bg-surface rounded-lg border border-border p-1">
<label class="flex-1 cursor-pointer">
<input checked="" class="peer sr-only" name="priority" type="radio" value="low"/>
<div class="text-center py-1.5 rounded-md font-label-sm text-label-sm peer-checked:bg-priority-low/10 peer-checked:text-priority-low text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                                Low
                                            </div>
</label>
<label class="flex-1 cursor-pointer">
<input class="peer sr-only" name="priority" type="radio" value="medium"/>
<div class="text-center py-1.5 rounded-md font-label-sm text-label-sm peer-checked:bg-priority-medium/10 peer-checked:text-priority-medium text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                                Medium
                                            </div>
</label>
<label class="flex-1 cursor-pointer">
<input class="peer sr-only" name="priority" type="radio" value="high"/>
<div class="text-center py-1.5 rounded-md font-label-sm text-label-sm peer-checked:bg-priority-high/10 peer-checked:text-priority-high text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                                High
                                            </div>
</label>
</div>
</div>
</div>
<!-- Deadline & Assignee -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-border">
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="task-deadline">Deadline</label>
<div class="relative">
<input required class="w-full h-[40px] pl-4 pr-10 bg-surface rounded-lg border border-border text-on-surface font-body-md text-body-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer" id="task-deadline" name="task-deadline" type="date"/>
<div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-on-surface-variant">
<span class="material-symbols-outlined text-[18px]">calendar_today</span>
</div>
</div>
</div>
</div>
<!-- Action Buttons -->
<div class="flex items-center justify-end gap-4 pt-6 mt-4 border-t border-border">
<button class="px-6 py-2 rounded-lg font-label-md text-label-md text-on-surface border border-transparent hover:border-border hover:bg-surface-container-low transition-colors" type="button">Cancel</button>
<button class="px-6 py-2 rounded-lg font-label-md text-label-md bg-primary-container text-on-primary hover:bg-primary shadow-sm hover:shadow-md transition-all active:scale-[0.98]" type="submit">Save Task</button>
</div>
</form>
</div>
</div>
<!-- Context Panel -->
<div class="hidden lg:block space-y-6">
<div class="bg-card-bg rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.1)] border border-border p-6">
<h3 class="font-headline-md text-headline-md text-on-surface mb-4">Quick Tips</h3>
<ul class="space-y-4 font-body-sm text-body-sm text-on-surface-variant">
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary text-[20px] shrink-0 mt-0.5">tips_and_updates</span>
<span>Keep titles concise and actionable. Start with a verb like "Update" or "Review".</span>
</li>
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-priority-medium text-[20px] shrink-0 mt-0.5">warning</span>
<span>Use High priority sparingly to ensure true emergencies stand out.</span>
</li>
<li class="flex items-start gap-3">
<span class="material-symbols-outlined text-status-todo text-[20px] shrink-0 mt-0.5">format_list_bulleted</span>
<span>Break down complex tasks in the description area.</span>
</li>
</ul>
</div>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 bg-surface dark:bg-inverse-surface shadow-lg border-t border-outline-variant dark:border-outline rounded-t-xl">
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="dashboard.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="home">home</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Home</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="tasks.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="list_alt">list_alt</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Tasks</span>
</a>
<a class="flex flex-col items-center justify-center text-primary dark:text-inverse-primary font-bold active:bg-surface-container-highest p-2 rounded-lg group" href="add_task.php"><span class="material-symbols-outlined group-hover:rotate-90 transition-transform duration-300" data-icon="add_circle">add_circle</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Add</span>
</a>
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="#"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="person">person</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Profile</span>
</a>
</nav>
</body></html>





