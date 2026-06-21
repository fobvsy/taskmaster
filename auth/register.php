<?php
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // No hash as per PRD

    // Check if email already exists
    $checkQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $error = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        // Insert new user
        $insertQuery = "INSERT INTO users (nama, email, password, role, status) VALUES ('$fullName', '$email', '$password', 'user', 'aktif')";
        if (mysqli_query($conn, $insertQuery)) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Terjadi kesalahan saat menyimpan data.";
        }
    }
}
?>
<!DOCTYPE html>
<html class="h-full" lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Registration - TaskMaster</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
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
</head>
<body class="bg-background h-full flex items-center justify-center font-body-md text-on-surface antialiased selection:bg-primary selection:text-on-primary">
<div class="w-full max-w-md px-margin-mobile md:px-0">
<!-- Logo Header -->
<div class="text-center mb-8">
<a href="../index.php" class="block font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary mb-2 hover:opacity-80 transition-opacity">TaskMaster</a>
<p class="font-body-md text-body-md text-on-surface-variant">Create your account to start managing tasks.</p>
</div>
<!-- Registration Card -->
<div class="bg-card-bg rounded-xl shadow-[0_1px_3px_rgba(0,0,0,0.1)] border border-border p-6 md:p-8 shadow-sm">
<?php if ($error): ?>
<div class="bg-[#ffdad6] text-[#93000a] border border-[#ba1a1a] rounded p-3 mb-4 text-sm">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>
<?php if ($success): ?>
<div class="bg-[#dcfce7] text-[#166534] border border-[#15803d] rounded p-3 mb-4 text-sm">
    <?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>
<form action="" class="space-y-6" method="POST">
<!-- Full Name Input -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="fullName">Full Name</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<span class="material-symbols-outlined text-outline" style="font-variation-settings: 'FILL' 0;">person</span>
</div>
<input class="block w-full h-[40px] pl-10 pr-3 py-2 border border-border rounded bg-surface-container-lowest text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent font-body-md text-body-md transition-shadow" id="fullName" name="fullName" placeholder="John Doe" required="" type="text"/>
</div>
</div>
<!-- Email Input -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="email">Email Address</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<span class="material-symbols-outlined text-outline" style="font-variation-settings: 'FILL' 0;">mail</span>
</div>
<input class="block w-full h-[40px] pl-10 pr-3 py-2 border border-border rounded bg-surface-container-lowest text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent font-body-md text-body-md transition-shadow" id="email" name="email" placeholder="you@example.com" required="" type="email"/>
</div>
</div>
<!-- Password Input -->
<div>
<label class="block font-label-md text-label-md text-on-surface mb-2" for="password">Password</label>
<div class="relative">
<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
<span class="material-symbols-outlined text-outline" style="font-variation-settings: 'FILL' 0;">lock</span>
</div>
<input class="block w-full h-[40px] pl-10 pr-10 py-2 border border-border rounded bg-surface-container-lowest text-on-surface focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent font-body-md text-body-md transition-shadow" id="password" name="password" placeholder="••••••••" required="" type="password"/>
<button aria-label="Toggle password visibility" class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-on-surface-variant transition-colors" type="button">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">visibility_off</span>
</button>
</div>
</div>

<!-- Submit Button -->
<div>
<button class="w-full flex justify-center items-center py-2 px-4 border border-transparent rounded bg-primary-container text-on-primary font-label-md text-label-md hover:bg-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors shadow-sm h-[40px]" type="submit">
                        Sign Up
                    </button>
</div>
</form>
<!-- Login Link -->
<div class="mt-6 text-center">
<p class="font-body-sm text-body-sm text-on-surface-variant">
                    Already have an account? 
                    <a class="font-label-md text-label-md text-primary hover:text-primary-container transition-colors ml-1" href="login.php">Login</a>
</p>
</div>
</div>
<!-- Footer -->
<div class="mt-8 text-center font-body-sm text-body-sm text-on-surface-variant">
<p class="">© 2024 TaskMaster. All rights reserved.</p>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('button[aria-label="Toggle password visibility"]');
        const passwordInput = document.getElementById('password');
        
        if (togglePassword && passwordInput) {
            const icon = togglePassword.querySelector('.material-symbols-outlined');
            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                // toggle the icon
                icon.textContent = type === 'password' ? 'visibility_off' : 'visibility';
            });
        }
    });
</script>
</body></html>