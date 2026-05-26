<?php
session_start();
 
// Nếu đã đăng nhập thì redirect
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
 
$errors = [];
$old_email = '';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $old_email = $email;
 
    // --- Validate email ---
    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không đúng định dạng (vd: abc@email.com).';
    }
 
    // --- Validate password ---
    if (empty($password)) {
        $errors['password'] = 'Vui lòng nhập mật khẩu.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }
 
    // --- Nếu không có lỗi thì kiểm tra DB ---
    if (empty($errors)) {
        // TODO: Thay đoạn này bằng truy vấn DB thực tế
        // Ví dụ mẫu kiểm tra tài khoản cứng:
        $demo_users = [
            ['email' => 'admin@demo.com', 'password' => password_hash('123456', PASSWORD_DEFAULT), 'name' => 'Admin']
        ];
 
        $found = false;
        foreach ($demo_users as $u) {
            if ($u['email'] === $email && password_verify($password, $u['password'])) {
                $_SESSION['user'] = ['email' => $u['email'], 'name' => $u['name']];
                $found = true;
                break;
            }
        }
 
        if ($found) {
            header('Location: dashboard.php');
            exit;
        } else {
            $errors['global'] = 'Email hoặc mật khẩu không chính xác.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
 
        :root {
            --green:        #0F6E56;
            --green-dark:   #085041;
            --green-light:  #E1F5EE;
            --green-ring:   rgba(15,110,86,0.15);
            --red:          #DC3545;
            --red-light:    #FFF0F0;
            --red-ring:     rgba(220,53,69,0.12);
            --gray-100:     #F8F9FA;
            --gray-200:     #E9ECEF;
            --gray-400:     #9CA3AF;
            --gray-600:     #4B5563;
            --gray-800:     #1F2937;
            --white:        #FFFFFF;
            --radius:       10px;
            --shadow:       0 4px 24px rgba(0,0,0,0.08);
        }
 
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: #F0F4F2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
 
        /* Background pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(15,110,86,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(15,110,86,0.06) 0%, transparent 50%);
            pointer-events: none;
        }
 
        .card {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp 0.4s ease;
        }
 
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
 
        /* Header */
        .card-header {
            background: var(--green);
            padding: 2rem 2rem 1.5rem;
            position: relative;
        }
 
        .card-header::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 0; right: 0;
            height: 28px;
            background: var(--white);
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
 
        .header-icon {
            width: 48px; height: 48px;
            background: rgba(255,255,255,0.18);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 12px;
        }
 
        .header-icon i { font-size: 24px; color: #fff; }
 
        .card-header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.4px;
        }
 
        .card-header p {
            color: rgba(255,255,255,0.72);
            font-size: 13.5px;
            margin-top: 4px;
        }
 
        /* Body */
        .card-body { padding: 1.75rem 2rem; }
 
        /* Alert tổng */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            border-radius: var(--radius);
            font-size: 13.5px;
            margin-bottom: 1.25rem;
        }
 
        .alert-danger {
            background: var(--red-light);
            color: var(--red);
            border: 1px solid rgba(220,53,69,0.2);
        }
 
        .alert i { font-size: 17px; flex-shrink: 0; margin-top: 1px; }
 
        /* Field */
        .field { margin-bottom: 1.1rem; }
 
        .field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--gray-600);
            margin-bottom: 6px;
        }
 
        .field label .required { color: var(--red); margin-left: 2px; }
 
        .input-wrap { position: relative; }
 
        .input-wrap .ico-left {
            position: absolute; left: 11px; top: 50%;
            transform: translateY(-50%);
            font-size: 17px; color: var(--gray-400);
            pointer-events: none; transition: color 0.15s;
        }
 
        .input-wrap input {
            width: 100%;
            height: 42px;
            padding: 0 38px;
            font-family: inherit;
            font-size: 14px;
            color: var(--gray-800);
            background: var(--gray-100);
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
 
        .input-wrap input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px var(--green-ring);
            background: var(--white);
        }
 
        .input-wrap input:focus ~ .ico-left { color: var(--green); }
 
        .input-wrap input.error {
            border-color: var(--red) !important;
            box-shadow: 0 0 0 3px var(--red-ring) !important;
            background: var(--red-light) !important;
        }
 
        .input-wrap input.success {
            border-color: var(--green) !important;
        }
 
        /* Icon trạng thái right */
        .ico-status {
            position: absolute; right: 11px; top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            display: none;
            pointer-events: none;
        }
 
        .ico-status.ok  { display: block; color: var(--green); }
        .ico-status.err { display: block; color: var(--red); }
 
        /* Nút toggle password */
        .btn-toggle-pw {
            position: absolute; right: 10px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer; color: var(--gray-400);
            display: flex; align-items: center;
            font-size: 17px; padding: 3px;
            transition: color 0.15s;
        }
 
        .btn-toggle-pw:hover { color: var(--gray-600); }
 
        /* Field error text */
        .field-error {
            display: none;
            align-items: center;
            gap: 5px;
            font-size: 12.5px;
            color: var(--red);
            margin-top: 5px;
        }
 
        .field-error.show { display: flex; }
        .field-error i { font-size: 14px; flex-shrink: 0; }
 
        /* Options row */
        .options-row {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            font-size: 13px;
        }
 
        .remember {
            display: flex; align-items: center; gap: 7px;
            cursor: pointer; color: var(--gray-600);
            user-select: none;
        }
 
        .remember input[type=checkbox] {
            width: 15px; height: 15px;
            accent-color: var(--green); cursor: pointer;
        }
 
        .link-green {
            color: var(--green); text-decoration: none; font-weight: 500;
        }
 
        .link-green:hover { text-decoration: underline; }
 
        /* Submit button */
        .btn-submit {
            width: 100%; height: 44px;
            background: var(--green);
            color: #fff;
            border: none; border-radius: var(--radius);
            font-family: inherit; font-size: 14.5px; font-weight: 600;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background 0.15s, transform 0.1s;
            letter-spacing: 0.1px;
        }
 
        .btn-submit:hover   { background: var(--green-dark); }
        .btn-submit:active  { transform: scale(0.985); }
        .btn-submit i { font-size: 18px; }
 
        /* Footer */
        .card-footer {
            border-top: 1px solid var(--gray-200);
            padding: 1rem 2rem;
            text-align: center;
            font-size: 13.5px;
            color: var(--gray-600);
            background: var(--gray-100);
        }
 
        /* PHP error class helper */
        .has-error .input-wrap input { border-color: var(--red); background: var(--red-light); }
        .has-error .field-error { display: flex; }
    </style>
</head>
<body>
 
<div class="card">
    <div class="card-header">
        <div class="header-icon">
            <i class="ti ti-shield-check"></i>
        </div>
        <h1>Đăng Nhập</h1>
        <p>Chào mừng bạn quay lại!</p>
    </div>
 
    <div class="card-body">
 
        <?php if (!empty($errors['global'])): ?>
            <div class="alert alert-danger">
                <i class="ti ti-alert-circle"></i>
                <span><?= htmlspecialchars($errors['global']) ?></span>
            </div>
        <?php endif; ?>
 
        <form action="login.php" method="POST" id="login-form" novalidate>
 
            <!-- Email -->
            <div class="field <?= isset($errors['email']) ? 'has-error' : '' ?>">
                <label for="email">Email <span class="required">*</span></label>
                <div class="input-wrap">
                    <i class="ti ti-mail ico-left"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="example@email.com"
                        value="<?= htmlspecialchars($old_email) ?>"
                        autocomplete="email"
                        class="<?= isset($errors['email']) ? 'error' : '' ?>"
                    >
                    <?php if (!isset($errors['email']) && !empty($old_email)): ?>
                        <i class="ti ti-circle-check ico-status ok"></i>
                    <?php elseif (isset($errors['email'])): ?>
                        <i class="ti ti-circle-x ico-status err"></i>
                    <?php else: ?>
                        <i class="ti ti-circle-check ico-status" id="email-ok"></i>
                        <i class="ti ti-circle-x   ico-status" id="email-err"></i>
                    <?php endif; ?>
                </div>
                <div class="field-error <?= isset($errors['email']) ? 'show' : '' ?>" id="email-fe">
                    <i class="ti ti-info-circle"></i>
                    <span id="email-fe-msg"><?= htmlspecialchars($errors['email'] ?? '') ?></span>
                </div>
            </div>
 
            <!-- Password -->
            <div class="field <?= isset($errors['password']) ? 'has-error' : '' ?>">
                <label for="password">Mật khẩu <span class="required">*</span></label>
                <div class="input-wrap">
                    <i class="ti ti-lock ico-left"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Nhập mật khẩu"
                        autocomplete="current-password"
                        class="<?= isset($errors['password']) ? 'error' : '' ?>"
                    >
                    <button class="btn-toggle-pw" type="button" id="toggle-pw" aria-label="Hiện/ẩn mật khẩu">
                        <i class="ti ti-eye" id="eye-icon"></i>
                    </button>
                </div>
                <div class="field-error <?= isset($errors['password']) ? 'show' : '' ?>" id="pw-fe">
                    <i class="ti ti-info-circle"></i>
                    <span id="pw-fe-msg"><?= htmlspecialchars($errors['password'] ?? '') ?></span>
                </div>
            </div>
 
            <!-- Options -->
            <div class="options-row">
                <label class="remember">
                    <input type="checkbox" name="remember" id="remember">
                    Ghi nhớ đăng nhập
                </label>
                <a href="forgot-password.php" class="link-green">Quên mật khẩu?</a>
            </div>
 
            <button type="submit" name="btn_login" class="btn-submit">
                <i class="ti ti-login"></i>
                Đăng nhập
            </button>
 
        </form>
    </div>
 
    <div class="card-footer">
        Chưa có tài khoản?
        <a href="register.php" class="link-green">Đăng ký ngay</a>
    </div>
</div>
 
<script>
(function () {
    const emailInput = document.getElementById('email');
    const pwInput    = document.getElementById('password');
    const form       = document.getElementById('login-form');
 
    function isValidEmail(v) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }
 
    function showFieldError(inputEl, feId, msgId, msg) {
        inputEl.classList.add('error');
        inputEl.classList.remove('success');
        const fe = document.getElementById(feId);
        if (fe) {
            fe.classList.add('show');
            document.getElementById(msgId).textContent = msg;
        }
        // icon
        const ok  = document.getElementById(inputEl.id + '-ok');
        const err = document.getElementById(inputEl.id + '-err');
        if (ok)  ok.className  = 'ti ti-circle-check ico-status';
        if (err) err.className = 'ti ti-circle-x   ico-status err';
    }
 
    function clearFieldError(inputEl, feId, msgId) {
        inputEl.classList.remove('error');
        inputEl.classList.add('success');
        const fe = document.getElementById(feId);
        if (fe) {
            fe.classList.remove('show');
            document.getElementById(msgId).textContent = '';
        }
        const ok  = document.getElementById(inputEl.id + '-ok');
        const err = document.getElementById(inputEl.id + '-err');
        if (ok)  ok.className  = 'ti ti-circle-check ico-status ok';
        if (err) err.className = 'ti ti-circle-x   ico-status';
    }
 
    function validateEmail(show) {
        const v = emailInput.value.trim();
        if (!v) {
            if (show) showFieldError(emailInput, 'email-fe', 'email-fe-msg', 'Vui lòng nhập email.');
            return false;
        }
        if (!isValidEmail(v)) {
            if (show) showFieldError(emailInput, 'email-fe', 'email-fe-msg', 'Email không đúng định dạng (vd: abc@email.com).');
            return false;
        }
        clearFieldError(emailInput, 'email-fe', 'email-fe-msg');
        return true;
    }
 
    function validatePassword(show) {
        const v = pwInput.value;
        if (!v) {
            if (show) showFieldError(pwInput, 'pw-fe', 'pw-fe-msg', 'Vui lòng nhập mật khẩu.');
            return false;
        }
        if (v.length < 6) {
            if (show) showFieldError(pwInput, 'pw-fe', 'pw-fe-msg', 'Mật khẩu phải có ít nhất 6 ký tự.');
            return false;
        }
        pwInput.classList.remove('error');
        document.getElementById('pw-fe').classList.remove('show');
        return true;
    }
 
    // Realtime
    emailInput.addEventListener('blur',  () => validateEmail(true));
    emailInput.addEventListener('input', () => { if (emailInput.classList.contains('error')) validateEmail(true); });
    pwInput.addEventListener('blur',  () => validatePassword(true));
    pwInput.addEventListener('input', () => { if (pwInput.classList.contains('error')) validatePassword(true); });
 
    // Toggle password
    document.getElementById('toggle-pw').addEventListener('click', function () {
        const show = pwInput.type === 'password';
        pwInput.type = show ? 'text' : 'password';
        document.getElementById('eye-icon').className = show ? 'ti ti-eye-off' : 'ti ti-eye';
    });
 
    // Submit
    form.addEventListener('submit', function (e) {
        const okEmail = validateEmail(true);
        const okPw    = validatePassword(true);
        if (!okEmail || !okPw) {
            e.preventDefault();
        }
    });
})();
</script>
 
</body>
</html>