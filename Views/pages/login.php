<?php
// KHÔNG cần session_start() nếu đã có trong index.php

// Nếu đã đăng nhập
if (isset($_SESSION['user'])) {
    header('Location: ?pages=home');
    exit;
}

$errors = [];
$old_email = '';

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $old_email = $email;

    // Validate Email
    if (empty($email)) {
        $errors['email'] = 'Vui lòng nhập email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không đúng định dạng.';
    }

    // Validate Password
    if (empty($password)) {
        $errors['password'] = 'Vui lòng nhập mật khẩu.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
    }

    // Demo login
    if (empty($errors)) {

        $demo_users = [
            [
                'email' => 'admin@demo.com',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'name' => 'Admin'
            ]
        ];

        $found = false;

        foreach ($demo_users as $u) {

            if (
                $u['email'] === $email &&
                password_verify($password, $u['password'])
            ) {

                $_SESSION['user'] = [
                    'email' => $u['email'],
                    'name'  => $u['name']
                ];

                $found = true;
                break;
            }
        }

        if ($found) {
            header('Location: ?pages=home');
            exit;
        } else {
            $errors['global'] = 'Email hoặc mật khẩu không chính xác.';
        }
    }
}
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
.lg-page{
    min-height:85vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:3rem 1rem;
    background:#f7f5f0;
    position:relative;
    overflow:hidden;
    font-family:'DM Sans',sans-serif;
}

.lg-page::before{
    content:'';
    position:absolute;
    top:-120px;
    right:-120px;
    width:450px;
    height:450px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(15,110,86,0.10) 0%,transparent 70%);
}

.lg-page::after{
    content:'';
    position:absolute;
    bottom:-100px;
    left:-80px;
    width:320px;
    height:320px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(15,110,86,0.07) 0%,transparent 70%);
}

.lg-wrap{
    width:100%;
    max-width:950px;
    min-height:600px;
    display:flex;
    border-radius:24px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 32px 80px rgba(0,0,0,0.13),
               0 8px 24px rgba(0,0,0,0.07);
    position:relative;
    z-index:2;
    animation:fadeUp .5s ease;
}

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(25px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* LEFT */

.lg-left{
    flex:0 0 340px;
    background:linear-gradient(155deg,#0a5c45 0%,#0F6E56 45%,#1a8a6d 100%);
    padding:3rem 2.5rem;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    position:relative;
    overflow:hidden;
}

.lg-left::before{
    content:'';
    position:absolute;
    top:-60px;
    right:-60px;
    width:240px;
    height:240px;
    border-radius:50%;
    background:rgba(255,255,255,0.05);
}

.lg-left::after{
    content:'';
    position:absolute;
    bottom:-70px;
    left:-40px;
    width:260px;
    height:260px;
    border-radius:50%;
    background:rgba(255,255,255,0.04);
}

.lg-brand{
    position:relative;
    z-index:2;
}

.lg-logo{
    width:50px;
    height:50px;
    border-radius:14px;
    background:rgba(255,255,255,0.15);
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:1.4rem;
}

.lg-logo i{
    color:#fff;
    font-size:26px;
}

.lg-brand h1{
    font-family:'Playfair Display',serif;
    color:#fff;
    font-size:30px;
    line-height:1.2;
    margin-bottom:10px;
}

.lg-brand p{
    color:rgba(255,255,255,0.72);
    font-size:14px;
    line-height:1.7;
}

.lg-features{
    display:flex;
    flex-direction:column;
    gap:16px;
    position:relative;
    z-index:2;
}

.lg-feature{
    display:flex;
    gap:12px;
    align-items:center;
}

.lg-feature-icon{
    width:38px;
    height:38px;
    border-radius:10px;
    background:rgba(255,255,255,0.12);
    display:flex;
    align-items:center;
    justify-content:center;
}

.lg-feature-icon i{
    color:#fff;
    font-size:18px;
}

.lg-feature-text{
    color:rgba(255,255,255,0.82);
    font-size:13px;
    line-height:1.4;
}

.lg-feature-text strong{
    display:block;
    color:#fff;
    margin-bottom:2px;
}

.lg-copy{
    position:relative;
    z-index:2;
    text-align:center;
    color:rgba(255,255,255,0.45);
    font-size:12px;
}

/* RIGHT */

.lg-right{
    flex:1;
    padding:3rem;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.lg-step{
    display:flex;
    gap:6px;
    margin-bottom:2rem;
}

.lg-step span{
    height:4px;
    border-radius:99px;
    background:#e5e5e5;
}

.lg-step span:nth-child(1){
    width:28px;
    background:#0F6E56;
}

.lg-step span:nth-child(2){
    width:15px;
}

.lg-step span:nth-child(3){
    width:10px;
}

.lg-header h2{
    font-family:'Playfair Display',serif;
    font-size:30px;
    margin-bottom:6px;
    color:#111;
}

.lg-header p{
    color:#888;
    font-size:14px;
    margin-bottom:2rem;
}

/* ALERT */

.lg-alert{
    display:flex;
    gap:10px;
    align-items:flex-start;
    background:#fff0f0;
    border:1px solid rgba(220,53,69,0.18);
    color:#dc3545;
    padding:12px 14px;
    border-radius:10px;
    margin-bottom:1.3rem;
    font-size:13px;
}

/* FIELD */

.lg-field{
    margin-bottom:1.2rem;
}

.lg-field label{
    display:block;
    margin-bottom:7px;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.04em;
    font-weight:500;
    color:#555;
}

.req{
    color:#e05c5c;
}

.lg-input-wrap{
    position:relative;
}

.lg-input-wrap input{
    width:100%;
    height:46px;
    border-radius:10px;
    border:1.5px solid #e8e8e8;
    background:#fafafa;
    outline:none;
    padding:0 42px;
    font-size:14px;
    transition:.2s;
    font-family:'DM Sans',sans-serif;
}

.lg-input-wrap input:focus{
    border-color:#0F6E56;
    background:#fff;
    box-shadow:0 0 0 3px rgba(15,110,86,0.12);
}

.lg-input-wrap input.is-err{
    border-color:#e05c5c!important;
    background:#fff8f8!important;
    box-shadow:0 0 0 3px rgba(224,92,92,0.10)!important;
}

.lg-input-wrap input.is-ok{
    border-color:#0F6E56!important;
}

.lg-ico{
    position:absolute;
    left:13px;
    top:50%;
    transform:translateY(-50%);
    color:#bbb;
    font-size:17px;
}

.lg-eye{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    border:none;
    background:none;
    cursor:pointer;
    color:#bbb;
    font-size:17px;
}

.lg-eye:hover{
    color:#555;
}

.lg-error{
    display:none;
    gap:5px;
    align-items:center;
    margin-top:6px;
    color:#e05c5c;
    font-size:12px;
}

.lg-error.show{
    display:flex;
}

/* OPTIONS */

.lg-options{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:1.5rem;
    font-size:13px;
}

.lg-remember{
    display:flex;
    align-items:center;
    gap:7px;
    color:#666;
}

.lg-remember input{
    accent-color:#0F6E56;
}

.lg-link{
    color:#0F6E56;
    text-decoration:none;
    font-weight:500;
}

.lg-link:hover{
    text-decoration:underline;
}

/* BUTTON */

.lg-btn{
    width:100%;
    height:48px;
    border:none;
    border-radius:10px;
    background:#0F6E56;
    color:#fff;
    font-size:15px;
    font-weight:500;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:.2s;
    box-shadow:0 4px 16px rgba(15,110,86,0.25);
}

.lg-btn:hover{
    background:#085041;
}

.lg-footer{
    margin-top:1.5rem;
    text-align:center;
    font-size:13px;
    color:#999;
}

.lg-footer a{
    color:#0F6E56;
    text-decoration:none;
    font-weight:500;
}

.lg-footer a:hover{
    text-decoration:underline;
}

/* MOBILE */

@media(max-width:768px){

    .lg-left{
        display:none;
    }

    .lg-right{
        padding:2.2rem 1.5rem;
    }

    .lg-wrap{
        border-radius:18px;
    }
}
</style>

<div class="lg-page">

    <div class="lg-wrap">

        <!-- LEFT -->
        <div class="lg-left">

            <div class="lg-brand">

                <div class="lg-logo">
                    <i class="ti ti-shield-lock"></i>
                </div>

                <h1>Đăng nhập vào Famms</h1>

                <p>
                    Tiếp tục mua sắm, theo dõi đơn hàng và nhận ưu đãi dành riêng cho thành viên.
                </p>

            </div>

            <div class="lg-features">

                <div class="lg-feature">
                    <div class="lg-feature-icon">
                        <i class="ti ti-shopping-cart"></i>
                    </div>

                    <div class="lg-feature-text">
                        <strong>Mua sắm dễ dàng</strong>
                        Truy cập nhanh giỏ hàng và đơn hàng
                    </div>
                </div>

                <div class="lg-feature">
                    <div class="lg-feature-icon">
                        <i class="ti ti-discount-2"></i>
                    </div>

                    <div class="lg-feature-text">
                        <strong>Ưu đãi độc quyền</strong>
                        Nhận voucher dành cho thành viên
                    </div>
                </div>

                <div class="lg-feature">
                    <div class="lg-feature-icon">
                        <i class="ti ti-lock-check"></i>
                    </div>

                    <div class="lg-feature-text">
                        <strong>Bảo mật an toàn</strong>
                        Dữ liệu của bạn luôn được bảo vệ
                    </div>
                </div>

            </div>

            <div class="lg-copy">
                © 2025 Famms. All rights reserved.
            </div>

        </div>

        <!-- RIGHT -->
        <div class="lg-right">

            <?php if (!empty($errors['global'])): ?>
                <div class="lg-alert">
                    <i class="ti ti-alert-circle"></i>
                    <span><?= htmlspecialchars($errors['global']) ?></span>
                </div>
            <?php endif; ?>

            <div class="lg-step">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="lg-header">
                <h2>Đăng nhập</h2>
                <p>Điền thông tin để tiếp tục</p>
            </div>

            <form method="POST" action="?pages=dang-nhap" id="login-form" novalidate>

                <!-- EMAIL -->
                <div class="lg-field">

                    <label>Email <span class="req">*</span></label>

                    <div class="lg-input-wrap">

                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="abc@email.com"
                            value="<?= htmlspecialchars($old_email) ?>"
                            class="<?= isset($errors['email']) ? 'is-err' : '' ?>"
                        >

                        <i class="ti ti-mail lg-ico"></i>

                    </div>

                    <div class="lg-error <?= isset($errors['email']) ? 'show' : '' ?>" id="email-error">
                        <i class="ti ti-info-circle"></i>
                        <span><?= htmlspecialchars($errors['email'] ?? '') ?></span>
                    </div>

                </div>

                <!-- PASSWORD -->
                <div class="lg-field">

                    <label>Mật khẩu <span class="req">*</span></label>

                    <div class="lg-input-wrap">

                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Nhập mật khẩu"
                            class="<?= isset($errors['password']) ? 'is-err' : '' ?>"
                        >

                        <i class="ti ti-lock lg-ico"></i>

                        <button type="button" class="lg-eye" id="togglePw">
                            <i class="ti ti-eye" id="eyeIcon"></i>
                        </button>

                    </div>

                    <div class="lg-error <?= isset($errors['password']) ? 'show' : '' ?>" id="password-error">
                        <i class="ti ti-info-circle"></i>
                        <span><?= htmlspecialchars($errors['password'] ?? '') ?></span>
                    </div>

                </div>

                <!-- OPTIONS -->
                <div class="lg-options">

                    <label class="lg-remember">
                        <input type="checkbox">
                        Ghi nhớ đăng nhập
                    </label>

                    <a href="#" class="lg-link">
                        Quên mật khẩu?
                    </a>

                </div>

                <!-- BUTTON -->
                <button type="submit" class="lg-btn">
                    <i class="ti ti-login"></i>
                    Đăng nhập
                </button>

            </form>

            <div class="lg-footer">
                Chưa có tài khoản?
                <a href="?pages=dang-ky">Đăng ký ngay</a>
            </div>

        </div>

    </div>

</div>

<script>
(function(){

    const emailEl = document.getElementById('email');
    const pwEl    = document.getElementById('password');
    const form    = document.getElementById('login-form');

    function isEmail(v){
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    }

    function showError(input,msgBox,msg){

        input.classList.add('is-err');

        const box = document.getElementById(msgBox);

        if(box){
            box.classList.add('show');
            box.querySelector('span').textContent = msg;
        }
    }

    function clearError(input,msgBox){

        input.classList.remove('is-err');
        input.classList.add('is-ok');

        const box = document.getElementById(msgBox);

        if(box){
            box.classList.remove('show');
        }
    }

    function validateEmail(show){

        const v = emailEl.value.trim();

        if(!v){

            if(show){
                showError(emailEl,'email-error','Vui lòng nhập email.');
            }

            return false;
        }

        if(!isEmail(v)){

            if(show){
                showError(emailEl,'email-error','Email không đúng định dạng.');
            }

            return false;
        }

        clearError(emailEl,'email-error');

        return true;
    }

    function validatePassword(show){

        const v = pwEl.value;

        if(!v){

            if(show){
                showError(pwEl,'password-error','Vui lòng nhập mật khẩu.');
            }

            return false;
        }

        if(v.length < 6){

            if(show){
                showError(pwEl,'password-error','Mật khẩu phải có ít nhất 6 ký tự.');
            }

            return false;
        }

        clearError(pwEl,'password-error');

        return true;
    }

    emailEl.addEventListener('blur',()=>validateEmail(true));

    pwEl.addEventListener('blur',()=>validatePassword(true));

    form.addEventListener('submit',function(e){

        const ok =
            validateEmail(true) &&
            validatePassword(true);

        if(!ok){
            e.preventDefault();
        }
    });

    // Toggle password

    document.getElementById('togglePw')
    .addEventListener('click',function(){

        const show = pwEl.type === 'password';

        pwEl.type = show ? 'text' : 'password';

        document.getElementById('eyeIcon').className =
            show ? 'ti ti-eye-off' : 'ti ti-eye';
    });

})();
</script>