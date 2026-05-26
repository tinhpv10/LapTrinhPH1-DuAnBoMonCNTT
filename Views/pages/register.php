<?php
session_start();
 
// Nếu đã đăng nhập thì redirect
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
 
$errors = [];
$old    = [];
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';
    $confirm  = $_POST['confirm']       ?? '';
    $agree    = isset($_POST['agree']);
 
    $old = compact('name', 'email');
 
    // --- Validate họ tên ---
    if (empty($name)) {
        $errors['name'] = 'Vui lòng nhập họ và tên.';
    } elseif (mb_strlen($name) < 2) {
        $errors['name'] = 'Họ tên phải có ít nhất 2 ký tự.';
    } elseif (mb_strlen($name) > 60) {
        $errors['name'] = 'Họ tên không được quá 60 ký tự.';
    }
 
    // --- Validate email ---
    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không đúng định dạng (vd: abc@email.com).';
    } else {
        // TODO: Kiểm tra email đã tồn tại trong DB
        // $exists = $db->query("SELECT id FROM users WHERE email = ?", [$email])->fetch();
        // if ($exists) $errors['email'] = 'Email này đã được đăng ký.';
    }
 
    // --- Validate password ---
    if (empty($password)) {
        $errors['password'] = 'Vui lòng nhập mật khẩu.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors['password'] = 'Mật khẩu phải gồm cả chữ và số.';
    }
 
    // --- Validate confirm password ---
    if (empty($confirm)) {
        $errors['confirm'] = 'Vui lòng xác nhận mật khẩu.';
    } elseif ($confirm !== $password) {
        $errors['confirm'] = 'Mật khẩu xác nhận không khớp.';
    }
 
    // --- Validate agree ---
    if (!$agree) {
        $errors['agree'] = 'Bạn cần đồng ý với điều khoản sử dụng.';
    }
 
    // --- Nếu không lỗi thì lưu DB ---
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
 
        // TODO: Lưu vào DB
        // $db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", [$name, $email, $hashed]);
 
        // Giả lập thành công → redirect login
        $_SESSION['register_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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
 
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(15,110,86,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(15,110,86,0.06) 0%, transparent 50%);
            pointer-events: none;
        }
 
        .card {
            width: 100%;
            max-width: 440px;
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
        .card-header h1 { color:#fff; font-size:22px; font-weight:700; letter-spacing:-0.4px; }
        .card-header p  { color:rgba(255,255,255,0.72); font-size:13.5px; margin-top:4px; }
 
        .card-body { padding: 1.75rem 2rem; }
 
        /* Strength bar */
        .strength-bar-wrap {
            margin-top: 7px;
            display: none;
        }
 
        .strength-bar-wrap.show { display: block; }
 
        .strength-bars {
            display: flex; gap: 4px; margin-bottom: 4px;
        }
 
        .strength-bars span {
            flex: 1; height: 4px;
            border-radius: 99px;
            background: var(--gray-200);
            transition: background 0.25s;
        }
 
        .strength-label {
            font-size: 12px; font-weight: 500;
        }
 
        /* Field styles (same as login) */
        .field { margin-bottom: 1.1rem; }
 
        .field label {
            display: block;
            font-size: 13px; font-weight: 500;
            color: var(--gray-600); margin-bottom: 6px;
        }
 
        .field label .required { color: var(--red); margin-left: 2px; }
 
        .input-wrap { position: relative; }
 
        .input-wrap .ico-left {
            position: absolute; left:11px; top:50%;
            transform: translateY(-50%);
            font-size:17px; color: var(--gray-400);
            pointer-events: none; transition: color 0.15s;
        }
 
        .input-wrap input[type=text],
        .input-wrap input[type=email],
        .input-wrap input[type=password] {
            width: 100%; height: 42px;
            padding: 0 38px;
            font-family: inherit; font-size: 14px;
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
 
        .input-wrap input.success { border-color: var(--green) !important; }
 
        .ico-status {
            position: absolute; right:11px; top:50%;
            transform: translateY(-50%);
            font-size:17px; display:none; pointer-events:none;
        }
 
        .ico-status.ok  { display:block; color: var(--green); }
        .ico-status.err { display:block; color: var(--red); }
 
        .btn-toggle-pw {
            position: absolute; right:10px; top:50%;
            transform: translateY(-50%);
            background:none; border:none; cursor:pointer;
            color: var(--gray-400); display:flex; align-items:center;
            font-size:17px; padding:3px; transition: color 0.15s;
        }
 
        .btn-toggle-pw:hover { color: var(--gray-600); }
 
        .field-error {
            display:none; align-items:center;
            gap:5px; font-size:12.5px;
            color: var(--red); margin-top:5px;
        }
 
        .field-error.show { display:flex; }
        .field-error i { font-size:14px; flex-shrink:0; }
 
        /* Checkbox agree */
        .agree-row {
            display: flex; align-items: flex-start; gap: 9px;
            font-size: 13px; color: var(--gray-600);
            margin-bottom: 1.25rem; cursor: pointer;
        }
 
        .agree-row input[type=checkbox] {
            width: 16px; height: 16px; margin-top: 1px;
            accent-color: var(--green); cursor: pointer; flex-shrink:0;
        }
 
        .agree-error {
            display: none; font-size:12.5px;
            color: var(--red); margin-top:-10px;
            margin-bottom: 1rem;
            align-items:center; gap:5px;
        }
 
        .agree-error.show { display:flex; }
 
        .btn-submit {
            width:100%; height:44px;
            background: var(--green); color:#fff;
            border:none; border-radius: var(--radius);
            font-family:inherit; font-size:14.5px; font-weight:600;
            cursor:pointer; display:flex; align-items:center;
            justify-content:center; gap:8px;
            transition: background 0.15s, transform 0.1s;
            letter-spacing:0.1px;
        }
 
        .btn-submit:hover  { background: var(--green-dark); }
        .btn-submit:active { transform: scale(0.985); }
        .btn-submit i { font-size:18px; }
 
        .card-footer {
            border-top: 1px solid var(--gray-200);
            padding: 1rem 2rem; text-align:center;
            font-size:13.5px; color: var(--gray-600);
            background: var(--gray-100);
        }
 
        .link-green { color: var(--green); text-decoration:none; font-weight:500; }
        .link-green:hover { text-decoration:underline; }
 
        /* PHP error helper */
        .has-error .input-wrap input { border-color: var(--red) !important; background: var(--red-light) !important; }
        .has-error .field-error { display:flex; }
    </style>
</head>
<body>
 
<div class="card">
    <div class="card-header">
        <div class="header-icon">
            <i class="ti ti-user-plus"></i>
        </div>
        <h1>Đăng Ký</h1>
        <p>Tạo tài khoản miễn phí ngay hôm nay</p>
    </div>
 
    <div class="card-body">
        <form action="register.php" method="POST" id="reg-form" novalidate>
 
            <!-- Họ tên -->
            <div class="field <?= isset($errors['name']) ? 'has-error' : '' ?>">
                <label for="name">Họ và tên <span class="required">*</span></label>
                <div class="input-wrap">
                    <i class="ti ti-user ico-left"></i>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Nguyễn Văn A"
                        value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                        autocomplete="name"
                        class="<?= isset($errors['name']) ? 'error' : '' ?>"
                    >
                    <i class="ti ti-circle-check ico-status" id="name-ok"></i>
                    <i class="ti ti-circle-x   ico-status <?= isset($errors['name']) ? 'err' : '' ?>" id="name-err"></i>
                </div>
                <div class="field-error <?= isset($errors['name']) ? 'show' : '' ?>" id="name-fe">
                    <i class="ti ti-info-circle"></i>
                    <span id="name-fe-msg"><?= htmlspecialchars($errors['name'] ?? '') ?></span>
                </div>
            </div>
 
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
                        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                        autocomplete="email"
                        class="<?= isset($errors['email']) ? 'error' : '' ?>"
                    >
                    <i class="ti ti-circle-check ico-status" id="email-ok"></i>
                    <i class="ti ti-circle-x   ico-status <?= isset($errors['email']) ? 'err' : '' ?>" id="email-err"></i>
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
                        placeholder="Tối thiểu 6 ký tự, gồm chữ và số"
                        autocomplete="new-password"
                        class="<?= isset($errors['password']) ? 'error' : '' ?>"
                    >
                    <button class="btn-toggle-pw" type="button" id="toggle-pw1" aria-label="Hiện/ẩn mật khẩu">
                        <i class="ti ti-eye" id="eye1"></i>
                    </button>
                </div>
                <!-- Thanh độ mạnh -->
                <div class="strength-bar-wrap" id="strength-wrap">
                    <div class="strength-bars">
                        <span id="sb1"></span><span id="sb2"></span>
                        <span id="sb3"></span><span id="sb4"></span>
                    </div>
                    <span class="strength-label" id="strength-label"></span>
                </div>
                <div class="field-error <?= isset($errors['password']) ? 'show' : '' ?>" id="pw-fe">
                    <i class="ti ti-info-circle"></i>
                    <span id="pw-fe-msg"><?= htmlspecialchars($errors['password'] ?? '') ?></span>
                </div>
            </div>
 
            <!-- Confirm Password -->
            <div class="field <?= isset($errors['confirm']) ? 'has-error' : '' ?>">
                <label for="confirm">Xác nhận mật khẩu <span class="required">*</span></label>
                <div class="input-wrap">
                    <i class="ti ti-lock-check ico-left"></i>
                    <input
                        type="password"
                        id="confirm"
                        name="confirm"
                        placeholder="Nhập lại mật khẩu"
                        autocomplete="new-password"
                        class="<?= isset($errors['confirm']) ? 'error' : '' ?>"
                    >
                    <button class="btn-toggle-pw" type="button" id="toggle-pw2" aria-label="Hiện/ẩn mật khẩu">
                        <i class="ti ti-eye" id="eye2"></i>
                    </button>
                </div>
                <div class="field-error <?= isset($errors['confirm']) ? 'show' : '' ?>" id="confirm-fe">
                    <i class="ti ti-info-circle"></i>
                    <span id="confirm-fe-msg"><?= htmlspecialchars($errors['confirm'] ?? '') ?></span>
                </div>
            </div>
 
            <!-- Agree -->
            <label class="agree-row">
                <input type="checkbox" name="agree" id="agree" <?= isset($_POST['agree']) ? 'checked' : '' ?>>
                <span>Tôi đồng ý với <a href="#" class="link-green">điều khoản sử dụng</a> và <a href="#" class="link-green">chính sách bảo mật</a></span>
            </label>
            <div class="agree-error <?= isset($errors['agree']) ? 'show' : '' ?>" id="agree-fe">
                <i class="ti ti-info-circle" style="font-size:14px;"></i>
                <span id="agree-fe-msg"><?= htmlspecialchars($errors['agree'] ?? '') ?></span>
            </div>
 
            <button type="submit" name="btn_register" class="btn-submit">
                <i class="ti ti-user-plus"></i>
                Đăng ký ngay
            </button>
 
        </form>
    </div>
 
    <div class="card-footer">
        Đã có tài khoản?
        <a href="login.php" class="link-green">Đăng nhập</a>
    </div>
</div>
 
<script>
(function () {
    const nameInput    = document.getElementById('name');
    const emailInput   = document.getElementById('email');
    const pwInput      = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');
    const agreeCheck   = document.getElementById('agree');
    const form         = document.getElementById('reg-form');
 
    function isValidEmail(v) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }
 
    function setOk(inputEl, okId, errId, feId, msgId) {
        inputEl.classList.remove('error'); inputEl.classList.add('success');
        if (okId)  document.getElementById(okId).className  = 'ti ti-circle-check ico-status ok';
        if (errId) document.getElementById(errId).className = 'ti ti-circle-x   ico-status';
        if (feId)  document.getElementById(feId).classList.remove('show');
        if (msgId) document.getElementById(msgId).textContent = '';
    }
 
    function setErr(inputEl, okId, errId, feId, msgId, msg) {
        inputEl.classList.add('error'); inputEl.classList.remove('success');
        if (okId)  document.getElementById(okId).className  = 'ti ti-circle-check ico-status';
        if (errId) document.getElementById(errId).className = 'ti ti-circle-x   ico-status err';
        if (feId)  document.getElementById(feId).classList.add('show');
        if (msgId) document.getElementById(msgId).textContent = msg;
    }
 
    // ---- Name ----
    function validateName(show) {
        const v = nameInput.value.trim();
        if (!v)             { if (show) setErr(nameInput,'name-ok','name-err','name-fe','name-fe-msg','Vui lòng nhập họ và tên.'); return false; }
        if (v.length < 2)   { if (show) setErr(nameInput,'name-ok','name-err','name-fe','name-fe-msg','Họ tên phải có ít nhất 2 ký tự.'); return false; }
        if (v.length > 60)  { if (show) setErr(nameInput,'name-ok','name-err','name-fe','name-fe-msg','Họ tên không được quá 60 ký tự.'); return false; }
        setOk(nameInput,'name-ok','name-err','name-fe','name-fe-msg'); return true;
    }
 
    // ---- Email ----
    function validateEmail(show) {
        const v = emailInput.value.trim();
        if (!v)              { if (show) setErr(emailInput,'email-ok','email-err','email-fe','email-fe-msg','Vui lòng nhập email.'); return false; }
        if (!isValidEmail(v)){ if (show) setErr(emailInput,'email-ok','email-err','email-fe','email-fe-msg','Email không đúng định dạng (vd: abc@email.com).'); return false; }
        setOk(emailInput,'email-ok','email-err','email-fe','email-fe-msg'); return true;
    }
 
    // ---- Password + strength ----
    function calcStrength(v) {
        let s = 0;
        if (v.length >= 6)  s++;
        if (v.length >= 10) s++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
        if (/[^A-Za-z0-9]/.test(v)) s++;
        return s;
    }
 
    const strengthColors = ['','#DC3545','#FFA500','#0F6E56','#085041'];
    const strengthLabels = ['','Yếu','Trung bình','Mạnh','Rất mạnh'];
    const strengthLabelColors = ['','#DC3545','#FFA500','#0F6E56','#085041'];
 
    function updateStrength() {
        const v = pwInput.value;
        const wrap = document.getElementById('strength-wrap');
        if (!v) { wrap.classList.remove('show'); return; }
        wrap.classList.add('show');
        const s = Math.max(1, calcStrength(v));
        for (let i = 1; i <= 4; i++) {
            document.getElementById('sb' + i).style.background = i <= s ? strengthColors[s] : '#E9ECEF';
        }
        const lbl = document.getElementById('strength-label');
        lbl.textContent = strengthLabels[s];
        lbl.style.color = strengthLabelColors[s];
    }
 
    function validatePassword(show) {
        const v = pwInput.value;
        if (!v)             { if (show) setErr(pwInput,null,null,'pw-fe','pw-fe-msg','Vui lòng nhập mật khẩu.'); return false; }
        if (v.length < 6)   { if (show) setErr(pwInput,null,null,'pw-fe','pw-fe-msg','Mật khẩu phải có ít nhất 6 ký tự.'); return false; }
        if (!/[A-Za-z]/.test(v) || !/[0-9]/.test(v)) {
            if (show) setErr(pwInput,null,null,'pw-fe','pw-fe-msg','Mật khẩu phải gồm cả chữ và số.'); return false;
        }
        pwInput.classList.remove('error'); document.getElementById('pw-fe').classList.remove('show');
        return true;
    }
 
    // ---- Confirm ----
    function validateConfirm(show) {
        const v = confirmInput.value;
        if (!v)                  { if (show) setErr(confirmInput,null,null,'confirm-fe','confirm-fe-msg','Vui lòng xác nhận mật khẩu.'); return false; }
        if (v !== pwInput.value) { if (show) setErr(confirmInput,null,null,'confirm-fe','confirm-fe-msg','Mật khẩu xác nhận không khớp.'); return false; }
        confirmInput.classList.remove('error'); confirmInput.classList.add('success');
        document.getElementById('confirm-fe').classList.remove('show');
        return true;
    }
 
    // ---- Agree ----
    function validateAgree(show) {
        if (!agreeCheck.checked) {
            if (show) {
                document.getElementById('agree-fe').classList.add('show');
                document.getElementById('agree-fe-msg').textContent = 'Bạn cần đồng ý với điều khoản sử dụng.';
            }
            return false;
        }
        document.getElementById('agree-fe').classList.remove('show');
        return true;
    }
 
    // Realtime listeners
    nameInput.addEventListener('blur',  () => validateName(true));
    nameInput.addEventListener('input', () => { if (nameInput.classList.contains('error')) validateName(true); });
 
    emailInput.addEventListener('blur',  () => validateEmail(true));
    emailInput.addEventListener('input', () => { if (emailInput.classList.contains('error')) validateEmail(true); });
 
    pwInput.addEventListener('input', () => {
        updateStrength();
        if (pwInput.classList.contains('error')) validatePassword(true);
        if (confirmInput.value) validateConfirm(false);
    });
    pwInput.addEventListener('blur', () => validatePassword(true));
 
    confirmInput.addEventListener('blur',  () => validateConfirm(true));
    confirmInput.addEventListener('input', () => { if (confirmInput.classList.contains('error')) validateConfirm(true); });
 
    agreeCheck.addEventListener('change', () => validateAgree(true));
 
    // Toggle password buttons
    document.getElementById('toggle-pw1').addEventListener('click', function () {
        const show = pwInput.type === 'password';
        pwInput.type = show ? 'text' : 'password';
        document.getElementById('eye1').className = show ? 'ti ti-eye-off' : 'ti ti-eye';
    });
 
    document.getElementById('toggle-pw2').addEventListener('click', function () {
        const show = confirmInput.type === 'password';
        confirmInput.type = show ? 'text' : 'password';
        document.getElementById('eye2').className = show ? 'ti ti-eye-off' : 'ti ti-eye';
    });
 
    // Submit
    form.addEventListener('submit', function (e) {
        const okName    = validateName(true);
        const okEmail   = validateEmail(true);
        const okPw      = validatePassword(true);
        const okConfirm = validateConfirm(true);
        const okAgree   = validateAgree(true);
        if (!okName || !okEmail || !okPw || !okConfirm || !okAgree) {
            e.preventDefault();
            // Scroll tới lỗi đầu tiên
            const firstErr = form.querySelector('.error, .agree-error.show');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
 
})();
</script>
 
</body>
</html>