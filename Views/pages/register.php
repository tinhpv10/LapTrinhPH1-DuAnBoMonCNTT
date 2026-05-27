<?php
// KHÔNG cần session_start() - đã có trong index.php

if (isset($_SESSION['user'])) {
    // SỬA LỖI: Dùng JavaScript điều hướng nếu header đã gửi đi
    echo '<script>window.location.href = "?pages=home";</script>';
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

    if (empty($name)) {
        $errors['name'] = 'Vui lòng nhập họ và tên.';
    } elseif (mb_strlen($name) < 2) {
        $errors['name'] = 'Họ tên phải có ít nhất 2 ký tự.';
    } elseif (mb_strlen($name) > 60) {
        $errors['name'] = 'Họ tên không được quá 60 ký tự.';
    }

    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không đúng định dạng (vd: abc@email.com).';
    }

    if (empty($password)) {
        $errors['password'] = 'Vui lòng nhập mật khẩu.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors['password'] = 'Mật khẩu phải gồm cả chữ và số.';
    }

    if (empty($confirm)) {
        $errors['confirm'] = 'Vui lòng xác nhận mật khẩu.';
    } elseif ($confirm !== $password) {
        $errors['confirm'] = 'Mật khẩu xác nhận không khớp.';
    }

    if (!$agree) {
        $errors['agree'] = 'Bạn cần đồng ý với điều khoản sử dụng.';
    }

    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        // TODO: Lưu vào DB
        $_SESSION['register_success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
        
        // SỬA LỖI: Chuyển hướng sang trang đăng nhập bằng JavaScript để sạch lỗi Warning
        echo '<script>window.location.href = "?pages=dang-nhap";</script>';
        exit;
    }
}
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
.rg-page {
    min-height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    position: relative;
    overflow: hidden;
    background: #f7f5f0;
    font-family: 'DM Sans', sans-serif;
}

/* Decorative background shapes */
.rg-page::before {
    content: '';
    position: absolute;
    top: -120px; right: -120px;
    width: 480px; height: 480px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(15,110,86,0.10) 0%, transparent 70%);
    pointer-events: none;
}
.rg-page::after {
    content: '';
    position: absolute;
    bottom: -100px; left: -80px;
    width: 360px; height: 360px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(15,110,86,0.07) 0%, transparent 70%);
    pointer-events: none;
}

.rg-wrap {
    display: flex;
    width: 100%;
    max-width: 960px;
    min-height: 600px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,0.13), 0 8px 24px rgba(0,0,0,0.07);
    position: relative;
    z-index: 1;
    animation: slideUp 0.5s cubic-bezier(.22,.68,0,1.2) both;
}

@keyframes slideUp {
    from { opacity:0; transform: translateY(28px); }
    to   { opacity:1; transform: translateY(0); }
}

/* ===== LEFT PANEL ===== */
.rg-left {
    flex: 0 0 340px;
    background: linear-gradient(155deg, #0a5c45 0%, #0F6E56 45%, #1a8a6d 100%);
    padding: 3rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.rg-left::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.rg-left::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -40px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.rg-brand {
    position: relative; z-index: 1;
}
.rg-brand-logo {
    width: 48px; height: 48px;
    background: rgba(255,255,255,0.15);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(4px);
}
.rg-brand-logo i { font-size: 26px; color: #fff; }

.rg-brand h1 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #fff;
    line-height: 1.2;
    margin: 0 0 12px;
    font-weight: 600;
}
.rg-brand p {
    font-size: 14px;
    color: rgba(255,255,255,0.70);
    line-height: 1.65;
    margin: 0;
}

.rg-features {
    position: relative; z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.rg-feature {
    display: flex;
    align-items: center;
    gap: 12px;
}
.rg-feature-icon {
    width: 36px; height: 36px; flex-shrink: 0;
    background: rgba(255,255,255,0.12);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
}
.rg-feature-icon i { font-size: 18px; color: rgba(255,255,255,0.90); }
.rg-feature-text { font-size: 13px; color: rgba(255,255,255,0.80); line-height: 1.4; }
.rg-feature-text strong { display: block; color: #fff; font-weight: 500; font-size: 13.5px; margin-bottom: 1px; }

.rg-footer-note {
    position: relative; z-index: 1;
    font-size: 12px;
    color: rgba(255,255,255,0.45);
    text-align: center;
}

/* ===== RIGHT PANEL ===== */
.rg-right {
    flex: 1;
    background: #fff;
    padding: 3rem 3rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.rg-right-header {
    margin-bottom: 2rem;
}
.rg-right-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    color: #111;
    margin: 0 0 6px;
    font-weight: 600;
}
.rg-right-header p {
    font-size: 14px;
    color: #888;
    margin: 0;
}

/* Row 2 columns */
.rg-row { display: flex; gap: 16px; }
.rg-row .rg-field { flex: 1; }

/* Field */
.rg-field { margin-bottom: 1.15rem; }
.rg-field label {
    display: block;
    font-size: 12.5px;
    font-weight: 500;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #555;
    margin-bottom: 7px;
}
.rg-field label .req { color: #e05c5c; margin-left: 2px; }

.rg-input-wrap { position: relative; }
.rg-input-wrap .ico {
    position: absolute; left: 13px; top: 50%;
    transform: translateY(-50%);
    font-size: 16px; color: #bbb;
    pointer-events: none;
    transition: color 0.15s;
}

.rg-input-wrap input {
    width: 100%;
    height: 44px;
    padding: 0 42px 0 40px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: #111;
    background: #fafafa;
    border: 1.5px solid #e8e8e8;
    border-radius: 10px;
    outline: none;
    transition: all 0.18s;
}
.rg-input-wrap input::placeholder { color: #c5c5c5; }
.rg-input-wrap input:hover { border-color: #ccc; background: #f5f5f5; }
.rg-input-wrap input:focus {
    border-color: #0F6E56;
    background: #fff;
    box-shadow: 0 0 0 3.5px rgba(15,110,86,0.10);
}
.rg-input-wrap input:focus + .ico { color: #0F6E56; }
.rg-input-wrap input.is-err {
    border-color: #e05c5c !important;
    background: #fff8f8 !important;
    box-shadow: 0 0 0 3px rgba(224,92,92,0.10) !important;
}
.rg-input-wrap input.is-ok { border-color: #0F6E56 !important; }

.ico-right {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    display: none; pointer-events: none;
}
.ico-right.ok  { display: block; color: #0F6E56; }
.ico-right.err { display: block; color: #e05c5c; }

.btn-eye {
    position: absolute; right: 11px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #bbb; font-size: 17px;
    display: flex; align-items: center;
    padding: 3px; transition: color 0.15s;
}
.btn-eye:hover { color: #555; }

.rg-err-msg {
    display: none; align-items: center; gap: 5px;
    font-size: 12px; color: #e05c5c; margin-top: 5px;
}
.rg-err-msg.show { display: flex; }
.rg-err-msg i { font-size: 13px; flex-shrink: 0; }

/* Strength bar */
.str-wrap { margin-top: 8px; display: none; }
.str-wrap.show { display: block; }
.str-bars { display: flex; gap: 4px; margin-bottom: 4px; }
.str-bars span {
    flex: 1; height: 3px; border-radius: 99px;
    background: #eee; transition: background 0.25s;
}
.str-lbl { font-size: 11.5px; font-weight: 500; }

/* Agree */
.rg-agree {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: 13px; color: #666;
    margin-bottom: 1.35rem; cursor: pointer;
    line-height: 1.5;
}
.rg-agree input[type=checkbox] {
    width: 16px; height: 16px; margin-top: 2px;
    accent-color: #0F6E56; flex-shrink: 0; cursor: pointer;
}
.rg-agree a { color: #0F6E56; text-decoration: none; font-weight: 500; }
.rg-agree a:hover { text-decoration: underline; }

.rg-agree-err {
    display: none; font-size: 12px; color: #e05c5c;
    margin: -8px 0 14px; align-items: center; gap: 5px;
}
.rg-agree-err.show { display: flex; }

/* Submit */
.rg-btn {
    width: 100%; height: 46px;
    background: #0F6E56;
    color: #fff;
    border: none; border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14.5px; font-weight: 500;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    letter-spacing: 0.02em;
    position: relative; overflow: hidden;
    transition: background 0.18s, transform 0.1s, box-shadow 0.18s;
    box-shadow: 0 4px 16px rgba(15,110,86,0.25);
}
.rg-btn:hover {
    background: #085041;
    box-shadow: 0 6px 20px rgba(15,110,86,0.35);
}
.rg-btn:active { transform: scale(0.985); }
.rg-btn i { font-size: 18px; }

/* Shimmer on hover */
.rg-btn::after {
    content: '';
    position: absolute;
    top: 0; left: -100%; width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transform: skewX(-20deg);
    transition: left 0.5s;
}
.rg-btn:hover::after { left: 150%; }

/* Divider */
.rg-divider {
    text-align: center;
    font-size: 13px;
    color: #aaa;
    margin: 1.25rem 0 0;
}
.rg-divider a {
    color: #0F6E56; text-decoration: none; font-weight: 500;
}
.rg-divider a:hover { text-decoration: underline; }

/* Step dots decorative */
.rg-step-dots {
    display: flex; gap: 6px; margin-bottom: 2rem;
}
.rg-step-dots span {
    height: 4px; border-radius: 2px;
    background: #e8e8e8;
    transition: background 0.3s, width 0.3s;
}
.rg-step-dots span:nth-child(1) { width: 28px; background: #0F6E56; }
.rg-step-dots span:nth-child(2) { width: 16px; }
.rg-step-dots span:nth-child(3) { width: 10px; }

/* Alert success */
.rg-success-alert {
    display: flex; align-items: center; gap: 10px;
    background: #e8f5f0; border: 1px solid #9fd4c0;
    color: #085041; padding: 11px 14px;
    border-radius: 10px; font-size: 13.5px;
    margin-bottom: 1.25rem;
}

/* Responsive */
@media (max-width: 768px) {
    .rg-left { display: none; }
    .rg-right { padding: 2.5rem 1.75rem; }
    .rg-row { flex-direction: column; gap: 0; }
    .rg-wrap { border-radius: 18px; }
}
</style>

<div class="rg-page">
<div class="rg-wrap">

    <div class="rg-left">
        <div class="rg-brand">
            <div class="rg-brand-logo">
                <i class="ti ti-hanger"></i>
            </div>
            <h1>Chào mừng đến với Famms</h1>
            <p>Tạo tài khoản để khám phá hàng ngàn mẫu thời trang độc đáo và nhận ưu đãi riêng.</p>
        </div>

        <div class="rg-features">
            <div class="rg-feature">
                <div class="rg-feature-icon"><i class="ti ti-truck-delivery"></i></div>
                <div class="rg-feature-text">
                    <strong>Giao hàng nhanh</strong>
                    Toàn quốc trong 1–3 ngày
                </div>
            </div>
            <div class="rg-feature">
                <div class="rg-feature-icon"><i class="ti ti-shield-check"></i></div>
                <div class="rg-feature-text">
                    <strong>Bảo mật tuyệt đối</strong>
                    Thông tin của bạn được mã hóa
                </div>
            </div>
            <div class="rg-feature">
                <div class="rg-feature-icon"><i class="ti ti-gift"></i></div>
                <div class="rg-feature-text">
                    <strong>Ưu đãi thành viên</strong>
                    Giảm 10% đơn hàng đầu tiên
                </div>
            </div>
            <div class="rg-feature">
                <div class="rg-feature-icon"><i class="ti ti-refresh"></i></div>
                <div class="rg-feature-text">
                    <strong>Đổi trả dễ dàng</strong>
                    Miễn phí trong vòng 30 ngày
                </div>
            </div>
        </div>

        <div class="rg-footer-note">© 2025 Famms. All rights reserved.</div>
    </div>

    <div class="rg-right">

        <?php if (!empty($_SESSION['register_success'])): ?>
        <div class="rg-success-alert">
            <i class="ti ti-circle-check" style="font-size:18px;flex-shrink:0;"></i>
            <?= htmlspecialchars($_SESSION['register_success']) ?>
        </div>
        <?php unset($_SESSION['register_success']); endif; ?>

        <div class="rg-right-header">
            <div class="rg-step-dots">
                <span></span><span></span><span></span>
            </div>
            <h2>Tạo tài khoản mới</h2>
            <p>Điền thông tin bên dưới để bắt đầu</p>
        </div>

        <form action="?pages=dang-ky" method="POST" id="reg-form" novalidate>

            <div class="rg-row">
                <div class="rg-field">
                    <label for="reg-name">Họ và tên <span class="req">*</span></label>
                    <div class="rg-input-wrap">
                        <input type="text" id="reg-name" name="name"
                            placeholder="Nguyễn Văn A"
                            value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                            autocomplete="name"
                            class="<?= isset($errors['name']) ? 'is-err' : '' ?>">
                        <i class="ti ti-user ico"></i>
                        <i class="ti ti-circle-check ico-right <?= (!isset($errors['name']) && !empty($old['name'])) ? 'ok' : '' ?>" id="name-ok"></i>
                        <i class="ti ti-circle-x   ico-right <?= isset($errors['name']) ? 'err' : '' ?>" id="name-err"></i>
                    </div>
                    <div class="rg-err-msg <?= isset($errors['name']) ? 'show' : '' ?>" id="name-fe">
                        <i class="ti ti-info-circle"></i>
                        <span id="name-fe-msg"><?= htmlspecialchars($errors['name'] ?? '') ?></span>
                    </div>
                </div>

                <div class="rg-field">
                    <label for="reg-email">Email <span class="req">*</span></label>
                    <div class="rg-input-wrap">
                        <input type="email" id="reg-email" name="email"
                            placeholder="abc@email.com"
                            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                            autocomplete="email"
                            class="<?= isset($errors['email']) ? 'is-err' : '' ?>">
                        <i class="ti ti-mail ico"></i>
                        <i class="ti ti-circle-check ico-right <?= (!isset($errors['email']) && !empty($old['email'])) ? 'ok' : '' ?>" id="email-ok"></i>
                        <i class="ti ti-circle-x   ico-right <?= isset($errors['email']) ? 'err' : '' ?>" id="email-err"></i>
                    </div>
                    <div class="rg-err-msg <?= isset($errors['email']) ? 'show' : '' ?>" id="email-fe">
                        <i class="ti ti-info-circle"></i>
                        <span id="email-fe-msg"><?= htmlspecialchars($errors['email'] ?? '') ?></span>
                    </div>
                </div>
            </div>

            <div class="rg-row">
                <div class="rg-field">
                    <label for="reg-pw">Mật khẩu <span class="req">*</span></label>
                    <div class="rg-input-wrap">
                        <input type="password" id="reg-pw" name="password"
                            placeholder="Tối thiểu 6 ký tự"
                            autocomplete="new-password"
                            class="<?= isset($errors['password']) ? 'is-err' : '' ?>">
                        <i class="ti ti-lock ico"></i>
                        <button class="btn-eye" type="button" id="eye-btn1">
                            <i class="ti ti-eye" id="eye1"></i>
                        </</button>
                    </div>
                    <div class="str-wrap" id="str-wrap">
                        <div class="str-bars">
                            <span id="sb1"></span><span id="sb2"></span>
                            <span id="sb3"></span><span id="sb4"></span>
                        </div>
                        <span class="str-lbl" id="str-lbl"></span>
                    </div>
                    <div class="rg-err-msg <?= isset($errors['password']) ? 'show' : '' ?>" id="pw-fe">
                        <i class="ti ti-info-circle"></i>
                        <span id="pw-fe-msg"><?= htmlspecialchars($errors['password'] ?? '') ?></span>
                    </div>
                </div>

                <div class="rg-field">
                    <label for="reg-confirm">Xác nhận mật khẩu <span class="req">*</span></label>
                    <div class="rg-input-wrap">
                        <input type="password" id="reg-confirm" name="confirm"
                            placeholder="Nhập lại mật khẩu"
                            autocomplete="new-password"
                            class="<?= isset($errors['confirm']) ? 'is-err' : '' ?>">
                        <i class="ti ti-lock-check ico"></i>
                        <button class="btn-eye" type="button" id="eye-btn2">
                            <i class="ti ti-eye" id="eye2"></i>
                        </button>
                    </div>
                    <div class="rg-err-msg <?= isset($errors['confirm']) ? 'show' : '' ?>" id="confirm-fe">
                        <i class="ti ti-info-circle"></i>
                        <span id="confirm-fe-msg"><?= htmlspecialchars($errors['confirm'] ?? '') ?></span>
                    </div>
                </div>
            </div>

            <label class="rg-agree">
                <input type="checkbox" name="agree" id="agree" <?= isset($_POST['agree']) ? 'checked' : '' ?>>
                <span>Tôi đồng ý với <a href="#">điều khoản sử dụng</a> và <a href="#">chính sách bảo mật</a> của Famms</span>
            </label>
            <div class="rg-agree-err <?= isset($errors['agree']) ? 'show' : '' ?>" id="agree-fe">
                <i class="ti ti-info-circle" style="font-size:13px;"></i>
                <span id="agree-fe-msg"><?= htmlspecialchars($errors['agree'] ?? '') ?></span>
            </div>

            <button type="submit" name="btn_register" class="rg-btn">
                <i class="ti ti-user-plus"></i>
                Tạo tài khoản ngay
            </button>

        </form>

        <div class="rg-divider">
            Đã có tài khoản? <a href="?pages=dang-nhap">Đăng nhập</a>
        </div>

    </div>
</div>
</div>

<script>
(function(){
    const nameEl    = document.getElementById('reg-name');
    const emailEl   = document.getElementById('reg-email');
    const pwEl      = document.getElementById('reg-pw');
    const confirmEl = document.getElementById('reg-confirm');
    const agreeEl   = document.getElementById('agree');
    const form      = document.getElementById('reg-form');

    function isEmail(v){ return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); }

    function g(id){ return document.getElementById(id); }

    function setOk(inp, okId, errId, feId){
        inp.classList.remove('is-err'); inp.classList.add('is-ok');
        if(okId)  g(okId).className  = 'ti ti-circle-check ico-right ok';
        if(errId) g(errId).className = 'ti ti-circle-x ico-right';
        if(feId)  g(feId).classList.remove('show');
    }

    function setErr(inp, okId, errId, feId, msgId, msg){
        inp.classList.add('is-err'); inp.classList.remove('is-ok');
        if(okId)  g(okId).className  = 'ti ti-circle-check ico-right';
        if(errId) g(errId).className = 'ti ti-circle-x ico-right err';
        if(feId)  g(feId).classList.add('show');
        if(msgId) g(msgId).textContent = msg;
    }

    function vName(show){
        const v = nameEl.value.trim();
        if(!v)           { if(show) setErr(nameEl,'name-ok','name-err','name-fe','name-fe-msg','Vui lòng nhập họ và tên.'); return false; }
        if(v.length < 2) { if(show) setErr(nameEl,'name-ok','name-err','name-fe','name-fe-msg','Họ tên phải có ít nhất 2 ký tự.'); return false; }
        if(v.length > 60){ if(show) setErr(nameEl,'name-ok','name-err','name-fe','name-fe-msg','Họ tên không được quá 60 ký tự.'); return false; }
        setOk(nameEl,'name-ok','name-err','name-fe'); return true;
    }

    function vEmail(show){
        const v = emailEl.value.trim();
        if(!v)          { if(show) setErr(emailEl,'email-ok','email-err','email-fe','email-fe-msg','Vui lòng nhập email.'); return false; }
        if(!isEmail(v)) { if(show) setErr(emailEl,'email-ok','email-err','email-fe','email-fe-msg','Email không đúng định dạng.'); return false; }
        setOk(emailEl,'email-ok','email-err','email-fe'); return true;
    }

    const SC = ['','#e05c5c','#f59e0b','#0F6E56','#085041'];
    const SL = ['','Yếu','Trung bình','Mạnh','Rất mạnh'];

    function strength(v){
        let s=0;
        if(v.length>=6) s++;
        if(v.length>=10) s++;
        if(/[A-Z]/.test(v)&&/[a-z]/.test(v)) s++;
        if(/[^A-Za-z0-9]/.test(v)) s++;
        return s;
    }

    function updateStr(){
        const v = pwEl.value;
        const wrap = g('str-wrap');
        if(!v){ wrap.classList.remove('show'); return; }
        wrap.classList.add('show');
        const s = Math.max(1, strength(v));
        for(let i=1;i<=4;i++){
            const sb = g('sb'+i);
            if(sb) sb.style.background = i<=s ? SC[s] : '#eee';
        }
        const lbl = g('str-lbl');
        if(lbl){ lbl.textContent = SL[s]; lbl.style.color = SC[s]; }
    }

    function vPw(show){
        const v = pwEl.value;
        if(!v)          { if(show) setErr(pwEl,null,null,'pw-fe','pw-fe-msg','Vui lòng nhập mật khẩu.'); return false; }
        if(v.length < 6){ if(show) setErr(pwEl,null,null,'pw-fe','pw-fe-msg','Mật khẩu phải có ít nhất 6 ký tự.'); return false; }
        if(!/[A-Za-z]/.test(v)||!/[0-9]/.test(v)){ if(show) setErr(pwEl,null,null,'pw-fe','pw-fe-msg','Mật khẩu phải gồm cả chữ và số.'); return false; }
        pwEl.classList.remove('is-err');
        const fe = g('pw-fe'); if(fe) fe.classList.remove('show');
        return true;
    }

    function vConfirm(show){
        const v = confirmEl.value;
        if(!v)               { if(show) setErr(confirmEl,null,null,'confirm-fe','confirm-fe-msg','Vui lòng xác nhận mật khẩu.'); return false; }
        if(v !== pwEl.value) { if(show) setErr(confirmEl,null,null,'confirm-fe','confirm-fe-msg','Mật khẩu xác nhận không khớp.'); return false; }
        confirmEl.classList.remove('is-err'); confirmEl.classList.add('is-ok');
        const fe = g('confirm-fe'); if(fe) fe.classList.remove('show');
        return true;
    }

    function vAgree(show){
        if(!agreeEl.checked){
            if(show){ const fe=g('agree-fe'); if(fe) fe.classList.add('show'); const m=g('agree-fe-msg'); if(m) m.textContent='Bạn cần đồng ý với điều khoản.'; }
            return false;
        }
        const fe=g('agree-fe'); if(fe) fe.classList.remove('show');
        return true;
    }

    nameEl.addEventListener('blur',  ()=>vName(true));
    nameEl.addEventListener('input', ()=>{ if(nameEl.classList.contains('is-err')) vName(true); });
    emailEl.addEventListener('blur',  ()=>vEmail(true));
    emailEl.addEventListener('input', ()=>{ if(emailEl.classList.contains('is-err')) vEmail(true); });
    pwEl.addEventListener('input', ()=>{ updateStr(); if(pwEl.classList.contains('is-err')) vPw(true); if(confirmEl.value) vConfirm(false); });
    pwEl.addEventListener('blur', ()=>vPw(true));
    confirmEl.addEventListener('blur',  ()=>vConfirm(true));
    confirmEl.addEventListener('input', ()=>{ if(confirmEl.classList.contains('is-err')) vConfirm(true); });
    agreeEl.addEventListener('change', ()=>vAgree(true));

    g('eye-btn1').addEventListener('click', function(){
        const show = pwEl.type==='password';
        pwEl.type = show?'text':'password';
        g('eye1').className = show?'ti ti-eye-off':'ti ti-eye';
    });
    g('eye-btn2').addEventListener('click', function(){
        const show = confirmEl.type==='password';
        confirmEl.type = show?'text':'password';
        g('eye2').className = show?'ti ti-eye-off':'ti ti-eye';
    });

    form.addEventListener('submit', function(e){
        const ok = vName(true) & vEmail(true) & vPw(true) & vConfirm(true) & vAgree(true);
        if(!ok){
            e.preventDefault();
            const first = form.querySelector('.is-err');
            if(first) first.scrollIntoView({behavior:'smooth', block:'center'});
        }
    });
})();
</script>