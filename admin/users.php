<?php
session_start();
require_once '../config/database.php';

// Cek autentikasi & role
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

// Handle actions (Delete, Toggle Status)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];

    // Mencegah admin menghapus dirinya sendiri
    if ($id !== $_SESSION['id_user']) {
        if ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM users WHERE id_user = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
        } elseif ($action === 'toggle_status') {
            // Ambil status saat ini
            $stmt = $conn->prepare("SELECT status FROM users WHERE id_user = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($row = $res->fetch_assoc()) {
                $new_status = ($row['status'] === 'aktif') ? 'nonaktif' : 'aktif';
                $stmt_update = $conn->prepare("UPDATE users SET status = ? WHERE id_user = ?");
                $stmt_update->bind_param("si", $new_status, $id);
                $stmt_update->execute();
            }
        }
    }
    header('Location: users.php');
    exit;
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Search setup
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query = "";
$params = [];
$types = "";

if ($search !== '') {
    $search_query = "WHERE nama LIKE ? OR email LIKE ?";
    $like_search = "%$search%";
    $params = [$like_search, $like_search];
    $types = "ss";
}

// Get total items for pagination
$count_sql = "SELECT COUNT(*) as total FROM users $search_query";
$stmt_count = $conn->prepare($count_sql);
if ($search !== '') {
    $stmt_count->bind_param($types, ...$params);
}
$stmt_count->execute();
$total_result = $stmt_count->get_result()->fetch_assoc();
$total_users = $total_result['total'];
$total_pages = ceil($total_users / $limit);

// Get users data
$sql = "SELECT * FROM users $search_query ORDER BY created_at DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

$query_params = $params;
$query_params[] = $limit;
$query_params[] = $offset;
$query_types = $types . "ii";

$stmt->bind_param($query_types, ...$query_params);
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Helper untuk format teks
function getInitials($name) {
    $words = explode(" ", $name);
    $initials = "";
    foreach ($words as $w) {
        $initials .= strtoupper($w[0]);
        if (strlen($initials) >= 2) break;
    }
    return $initials ?: "U";
}
?>
<!DOCTYPE html>

<html class="light" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>TaskMaster - Manage Users</title>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
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

<a class="flex items-center gap-3 text-on-surface-variant dark:text-surface-variant px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant rounded-lg transition-all hover:translate-x-1 duration-300 group" href="categories.php">
<span class="material-symbols-outlined group-hover:scale-110 transition-transform duration-300" data-icon="category">category</span>
<span class="font-label-md text-label-md">Categories</span>
</a>
<a class="flex items-center gap-3 bg-secondary-container dark:bg-secondary text-on-secondary-container dark:text-on-secondary rounded-lg px-4 py-3 mx-2 translate-x-1 duration-200 group" href="users.php">
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
<main class="flex-1 md:ml-64 w-full flex flex-col min-h-screen">
<!-- TopAppBar (Mobile & Desktop overrides) -->
<header class="md:hidden flex justify-between items-center w-full px-margin-mobile py-4 bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline fixed top-0 z-30">
<span class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">TaskMaster</span>
<div class="flex items-center gap-4">
<button class="text-on-surface-variant">
<span class="material-symbols-outlined">menu</span>
</button>
</div>
</header>
<div class="flex-1 pt-20 md:pt-8 px-margin-mobile md:px-margin-desktop max-w-container-max-width mx-auto w-full pb-24 md:pb-8">
<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
<div>
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Manage Users</h1>
<p class="font-body-sm text-body-sm text-on-surface-variant mt-1">Administer user accounts, roles, and access.</p>
</div>
<div class="flex items-center gap-3">
<form method="GET" action="users.php" class="relative w-full md:w-64">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
<input name="search" value="<?= htmlspecialchars($search) ?>" class="w-full pl-10 pr-4 py-2 bg-surface-container rounded-lg border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary text-body-sm font-body-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant" placeholder="Search users..." type="text"/>
</form>
<button class="bg-primary text-on-primary px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-colors flex items-center gap-2 whitespace-nowrap">
<span class="material-symbols-outlined text-[18px]">person_add</span>
                        Add User
                    </button>
</div>
</div>
<!-- Data Table Card -->
<div class="bg-card-bg rounded-xl shadow-[0px_1px_3px_rgba(0,0,0,0.1)] border border-border overflow-hidden">
<div class="overflow-x-auto w-full">
<table class="w-full text-left border-collapse min-w-[800px]">
<thead>
<tr class="bg-surface-container-low border-b border-border">
<th class="font-label-md text-label-md text-on-surface-variant px-6 py-4 font-semibold uppercase tracking-wider">ID</th>
<th class="font-label-md text-label-md text-on-surface-variant px-6 py-4 font-semibold uppercase tracking-wider">Name</th>
<th class="font-label-md text-label-md text-on-surface-variant px-6 py-4 font-semibold uppercase tracking-wider">Email</th>
<th class="font-label-md text-label-md text-on-surface-variant px-6 py-4 font-semibold uppercase tracking-wider">Role</th>
<th class="font-label-md text-label-md text-on-surface-variant px-6 py-4 font-semibold uppercase tracking-wider">Status</th>
<th class="font-label-md text-label-md text-on-surface-variant px-6 py-4 font-semibold uppercase tracking-wider text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-border">
<?php if(empty($users)): ?>
    <tr>
        <td colspan="6" class="px-6 py-8 text-center text-on-surface-variant font-body-md">Tidak ada pengguna yang ditemukan.</td>
    </tr>
<?php else: ?>
    <?php foreach($users as $user): ?>
    <tr class="hover:bg-surface-bright transition-colors">
    <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant">#USR-<?= $user['id_user'] ?></td>
    <td class="px-6 py-4">
    <div class="flex items-center gap-3">
    <div class="w-8 h-8 rounded-full bg-primary text-on-primary flex items-center justify-center font-label-md shrink-0"><?= getInitials($user['nama']) ?></div>
    <span class="font-body-md text-body-md font-medium text-on-surface"><?= htmlspecialchars($user['nama']) ?></span>
    </div>
    </td>
    <td class="px-6 py-4 font-body-sm text-body-sm text-on-surface-variant"><?= htmlspecialchars($user['email']) ?></td>
    <td class="px-6 py-4">
    <?php if($user['role'] === 'admin'): ?>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary/10 text-primary">Admin</span>
    <?php else: ?>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant">User</span>
    <?php endif; ?>
    </td>
    <td class="px-6 py-4">
    <?php if($user['status'] === 'aktif'): ?>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-status-done/10 text-status-done">
        <span class="w-1.5 h-1.5 rounded-full bg-status-done"></span> Aktif
        </span>
    <?php else: ?>
        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-highest text-on-surface-variant">
        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Nonaktif
        </span>
    <?php endif; ?>
    </td>
    <td class="px-6 py-4 text-right">
    <div class="flex items-center justify-end gap-2">
    <?php if($user['id_user'] !== $_SESSION['id_user']): ?>
        <a href="users.php?action=toggle_status&id=<?= $user['id_user'] ?>" class="p-2 text-on-surface-variant hover:text-primary transition-colors rounded-lg hover:bg-surface-container" title="<?= $user['status'] === 'aktif' ? 'Nonaktifkan User' : 'Aktifkan User' ?>">
        <span class="material-symbols-outlined text-[20px]"><?= $user['status'] === 'aktif' ? 'block' : 'check_circle' ?></span>
        </a>
        <a href="users.php?action=delete&id=<?= $user['id_user'] ?>" onclick="return confirm('Yakin ingin menghapus user ini secara permanen?');" class="p-2 text-on-surface-variant hover:text-error transition-colors rounded-lg hover:bg-error-container/50" title="Hapus User">
        <span class="material-symbols-outlined text-[20px]">delete</span>
        </a>
    <?php endif; ?>
    </div>
    </td>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
</table>
</div>
<!-- Pagination Footer -->
<div class="px-6 py-4 border-t border-border bg-surface-bright flex items-center justify-between">
<?php
$start_item = $total_users > 0 ? $offset + 1 : 0;
$end_item = min($offset + $limit, $total_users);
?>
<span class="font-body-sm text-body-sm text-on-surface-variant">Showing <?= $start_item ?> to <?= $end_item ?> of <?= $total_users ?> users</span>
<div class="flex items-center gap-2">
<a href="<?= $page > 1 ? '?page='.($page-1).'&search='.urlencode($search) : '#' ?>" class="p-1 rounded bg-surface border border-border text-on-surface-variant <?= $page <= 1 ? 'opacity-50 pointer-events-none' : 'hover:bg-surface-container transition-colors' ?>">
<span class="material-symbols-outlined text-[20px]">chevron_left</span>
</a>
<?php for($i=1; $i<=$total_pages; $i++): ?>
    <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="w-8 h-8 rounded border border-border font-label-sm text-label-sm flex items-center justify-center transition-colors <?= $i === $page ? 'bg-primary text-on-primary' : 'bg-surface text-on-surface-variant hover:bg-surface-container' ?>">
        <?= $i ?>
    </a>
<?php endfor; ?>
<a href="<?= $page < $total_pages ? '?page='.($page+1).'&search='.urlencode($search) : '#' ?>" class="p-1 rounded bg-surface border border-border text-on-surface-variant <?= $page >= $total_pages ? 'opacity-50 pointer-events-none' : 'hover:bg-surface-container transition-colors' ?>">
<span class="material-symbols-outlined text-[20px]">chevron_right</span>
</a>
</div>
</div>
</div>
</div>
</main>
<!-- BottomNavBar (Mobile Only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 bg-surface dark:bg-inverse-surface shadow-md border-t border-outline-variant dark:border-outline docked full-width bottom-0 rounded-t-xl">
<a class="flex flex-col items-center justify-center text-on-surface-variant dark:text-surface-variant active:bg-surface-container-highest p-2 rounded-lg group" href="dashboard.php">
<span class="material-symbols-outlined mb-1 group-hover:scale-110 transition-transform duration-300" data-icon="home">home</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Home</span>
</a>


<a class="flex flex-col items-center justify-center text-primary dark:text-inverse-primary font-bold active:bg-surface-container-highest p-2 rounded-lg group" href="users.php">
<span class="material-symbols-outlined mb-1 group-hover:scale-110 transition-transform duration-300" data-icon="group">group</span>
<span class="font-label-sm text-label-sm-mobile mt-1">Users</span>
</a>
</nav>
</body></html>
