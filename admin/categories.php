<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$error = '';
$success = '';

// Handling Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $q = mysqli_query($conn, "DELETE FROM categories WHERE id_category = $id");
    if ($q) {
        $success = "Category deleted successfully!";
        header("Location: categories.php");
        exit();
    } else {
        $error = "Failed to delete category.";
    }
}

// Handling Add / Edit
$editId = null;
$editName = '';

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $qEdit = mysqli_query($conn, "SELECT * FROM categories WHERE id_category = $editId");
    if ($row = mysqli_fetch_assoc($qEdit)) {
        $editName = $row['category_name'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    
    if (isset($_POST['update_id'])) {
        // Update
        $id = (int)$_POST['update_id'];
        $q = mysqli_query($conn, "UPDATE categories SET category_name = '$category_name' WHERE id_category = $id");
        if ($q) {
            header("Location: categories.php");
            exit();
        } else {
            $error = "Failed to update category.";
        }
    } else {
        // Insert
        $q = mysqli_query($conn, "INSERT INTO categories (category_name) VALUES ('$category_name')");
        if ($q) {
            header("Location: categories.php");
            exit();
        } else {
            $error = "Failed to add category.";
        }
    }
}

// Fetch Categories
$qCategories = mysqli_query($conn, "
    SELECT c.*, 
           (SELECT COUNT(*) FROM tasks t WHERE t.id_category = c.id_category) as task_count 
    FROM categories c 
    ORDER BY c.created_at DESC
");
$categories = [];
while ($row = mysqli_fetch_assoc($qCategories)) {
    $categories[] = $row;
}
?>
<!DOCTYPE html>
<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Manage Categories - TaskMaster</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Hanken+Grotesk:wght@600;700&amp;display=swap" rel="stylesheet"/>
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
        body { background-color: theme('colors.background'); color: theme('colors.on-background'); }
    </style>
</head>
<body class="bg-background text-on-background font-body-md min-h-screen flex text-body-md overflow-x-hidden">
<!-- SideNavBar (Desktop) -->
<aside class="hidden md:flex flex-col h-screen py-4 gap-2 bg-surface-container-low dark:bg-inverse-surface border-r border-outline-variant fixed left-0 w-64 z-40">
<div class="px-4 py-6">
<h1 class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">Project Space</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant">Team Workspace</p>
</div>

<nav class="flex-1 flex flex-col gap-1 mt-4">
<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="dashboard.php">
<span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="dashboard">dashboard</span>
<span class="font-label-md text-label-md">Dashboard</span>
</a>

<a class="flex items-center gap-3 bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary rounded-lg px-4 py-3 mx-2 translate-x-1 duration-200 group" href="categories.php">
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
<!-- Main Content Area -->
<main class="flex-1 md:ml-64 pb-20 md:pb-0 min-h-screen flex flex-col">
<!-- Top Header Area (Mobile: App Bar, Desktop: Page Header) -->
<header class="bg-surface sticky top-0 z-30 px-margin-mobile md:px-margin-desktop py-6 border-b border-outline-variant/30 flex flex-col gap-4">
<div class="flex justify-between items-center">
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Manage Categories</h1>
<div class="flex items-center gap-4">
<button class="md:hidden text-on-surface p-2 rounded-full hover:bg-surface-variant">
<span class="material-symbols-outlined">menu</span>
</button>
</div>
</div>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Organize tasks systematically by creating and managing category labels. Changes here apply globally to all workspaces.</p>
</header>
<!-- Canvas -->
<div class="flex-1 p-margin-mobile md:p-margin-desktop bg-surface-container-lowest max-w-4xl w-full mx-auto">
<!-- Add Category Section -->
<section class="mb-8 p-gutter bg-card-bg rounded-xl border border-border shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
<h2 class="font-headline-md text-headline-md text-on-surface mb-4"><?= $editId ? 'Edit Category' : 'Add New Category' ?></h2>

<?php if($error): ?>
    <div class="mb-4 p-3 bg-error-container text-on-error-container rounded-lg font-body-sm text-body-sm"> <?= htmlspecialchars($error) ?> </div>
<?php endif; ?>

<form method="POST" action="categories.php" class="flex flex-col md:flex-row gap-4 items-start md:items-end">
<?php if($editId): ?>
    <input type="hidden" name="update_id" value="<?= $editId ?>">
<?php endif; ?>
<div class="flex-1 w-full">
<label class="block font-label-md text-label-md text-on-surface-variant mb-2" for="new-category">Category Name</label>
<input name="category_name" value="<?= htmlspecialchars($editName) ?>" class="w-full h-10 px-4 rounded-lg border border-border bg-surface focus:ring-2 focus:ring-primary-container focus:border-transparent font-body-md text-body-md text-on-surface outline-none transition-all shadow-sm" id="new-category" placeholder="e.g., Marketing, Development, HR" required="" type="text"/>
</div>
<button class="w-full md:w-auto h-10 px-6 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container transition-colors shadow-sm flex items-center justify-center gap-2" type="submit">
<span class="material-symbols-outlined text-[18px]"><?= $editId ? 'save' : 'add' ?></span>
                        <?= $editId ? 'Update Category' : 'Add Category' ?>
                    </button>
<?php if($editId): ?>
    <a href="categories.php" class="w-full md:w-auto h-10 px-6 bg-surface-variant text-on-surface-variant font-label-md text-label-md rounded-lg hover:bg-surface-container-highest transition-colors shadow-sm flex items-center justify-center gap-2">
        Cancel
    </a>
<?php endif; ?>
</form>
</section>
<!-- Category List Section -->
<section class="bg-card-bg rounded-xl border border-border overflow-hidden shadow-[0px_1px_3px_rgba(0,0,0,0.1)]">
<div class="bg-surface-container-low px-6 py-4 border-b border-border flex justify-between items-center">
<h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Active Categories</h3>
<span class="font-label-sm text-label-sm bg-surface-variant text-on-surface-variant px-2 py-1 rounded-full"><?= count($categories) ?> Items</span>
</div>
<ul class="divide-y divide-border">
<?php if(empty($categories)): ?>
    <li class="px-6 py-4 text-center text-on-surface-variant font-body-md">Belum ada kategori.</li>
<?php else: ?>
    <?php foreach($categories as $cat): ?>
    <li class="px-6 py-4 flex items-center justify-between hover:bg-surface-bright transition-colors group">
    <div class="flex items-center gap-4">
    <div class="w-3 h-3 rounded-full bg-primary"></div>
    <div>
    <h4 class="font-body-md text-body-md font-semibold text-on-surface"><?= htmlspecialchars($cat['category_name']) ?></h4>
    <p class="font-body-sm text-body-sm text-on-surface-variant"><?= $cat['task_count'] ?> Active Tasks</p>
    </div>
    </div>
    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
    <a href="categories.php?action=edit&id=<?= $cat['id_category'] ?>" class="p-2 text-on-surface-variant hover:text-primary hover:bg-surface-variant rounded-full transition-colors" title="Edit">
    <span class="material-symbols-outlined text-[20px]">edit</span>
    </a>
    <a href="categories.php?action=delete&id=<?= $cat['id_category'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Tasks terkait akan kehilangan kategori.');" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container rounded-full transition-colors" title="Delete">
    <span class="material-symbols-outlined text-[20px]">delete</span>
    </a>
    </div>
    </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>
</section>
</div>
</main>
<!-- BottomNavBar (Mobile) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 bg-surface dark:bg-inverse-surface shadow-lg border-t border-outline-variant dark:border-outline rounded-t-xl">
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="dashboard.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="home">home</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Home</span>
</a>

<!-- Active Mobile Category -->
<a class="flex flex-col items-center justify-center text-primary dark:text-inverse-primary font-bold active:bg-surface-container-highest p-2 rounded-lg group" href="categories.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="category">category</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Categories</span>
</a>
<!-- Active Mobile Users -->
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="users.php"><span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="group">group</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Users</span>
</a>
</nav>
</body></html>
