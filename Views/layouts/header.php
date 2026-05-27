<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
 
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
 
      <link rel="shortcut icon" href="assets/images/favicon.png" type="">
 
      <title>Famms - Website Thời Trang</title>
 
      <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
 
      <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
 
      <link href="assets/css/style.css" rel="stylesheet" />
 
      <link href="assets/css/responsive.css" rel="stylesheet" />

      <style>
         .custom_nav-container .navbar-collapse {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            justify-content: space-between;
            width: 100%;
         }

         .custom_nav-container .navbar-nav {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
         }

         .custom_nav-container .navbar-nav .nav-link {
            font-weight: 700 !important;
            text-transform: uppercase !important;
            color: #1a1a1a !important;
            padding: 10px 15px !important;
            white-space: nowrap !important; /* Giữ chữ trên cùng 1 hàng */
            transition: all 0.3s ease;
         }

         .custom_nav-container .navbar-nav .nav-item.active .nav-link,
         .custom_nav-container .navbar-nav .nav-link:hover {
            color: #f7444e !important; 
         }

         /* Cụm chức năng bên phải */
         .navbar_right-actions {
            margin-left: auto !important;
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            list-style: none !important;
            padding-left: 0 !important;
            margin-bottom: 0 !important;
            gap: 18px; /* Khoảng cách đều giữa các nút */
         }

         .navbar_right-actions .nav-item {
            white-space: nowrap !important;
         }

         /* Định dạng chung cho Icon SVG (Giỏ hàng & Tìm kiếm) */
         .nav-icon-svg {
            width: 20px;
            height: 20px;
            fill: #1a1a1a;
            transition: fill 0.3s ease;
            vertical-align: middle;
         }
         
         .nav-item:hover .nav-icon-svg,
         .btn-search-trigger:hover .nav-icon-svg {
            fill: #f7444e; /* Đổi màu đỏ khi hover */
         }

         /* Nút bấm tìm kiếm sạch lỗi ô vuông */
         .btn-search-trigger {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            outline: none !important;
         }

         /* Màu sắc nút Đăng nhập / Đăng ký theo ảnh mẫu */
         .btn-login-highlight {
            color: #007bff !important; /* Màu xanh dương giống ảnh mới nhất */
         }
         .btn-register-highlight {
            color: #f7444e !important; /* Màu đỏ giống ảnh mới nhất */
         }

         .dropdown-menu {
            border: none !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            border-radius: 4px !important;
         }
         .dropdown-item {
            font-weight: 600 !important;
            padding: 8px 20px !important;
         }
         .dropdown-item:hover {
            background-color: #f8f9fa !important;
            color: #f7444e !important;
         }
      </style>
   </head>
 
   <body>
 
      <div class="hero_area">
 
         <header class="header_section">
 
            <div class="container">
 
               <nav class="navbar navbar-expand-lg custom_nav-container">
 
                  <a class="navbar-brand" href="?pages=home">
                     <img width="250" src="assets/images/logo.png" alt="Famms Logo" />
                  </a>
 
                  <button class="navbar-toggler"
                          type="button"
                          data-toggle="collapse"
                          data-target="#navbarSupportedContent"
                          aria-controls="navbarSupportedContent"
                          aria-expanded="false"
                          aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                  </button>
 
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
 
                     <ul class="navbar-nav">
 
                        <li class="nav-item <?= (!isset($_GET['pages']) || $_GET['pages'] == 'home') ? 'active' : '' ?>">
                           <a class="nav-link" href="?pages=home">Trang Chủ</a>
                        </li>
 
                        <li class="nav-item dropdown">
                           <a class="nav-link dropdown-toggle"
                              href="#"
                              id="navbarDropdown"
                              data-toggle="dropdown"
                              role="button"
                              aria-haspopup="true"
                              aria-expanded="false">
                              Trang
                           </a>
                           <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <li><a class="dropdown-item" href="?pages=ho-so">Hồ Sơ</a></li>
                              <li><a class="dropdown-item" href="?pages=dang-nhap">Đăng Nhập</a></li>
                              <li><a class="dropdown-item" href="?pages=dang-ky">Đăng Ký</a></li>
                              <li><a class="dropdown-item" href="?pages=quen-mat-khau">Quên Mật Khẩu</a></li>
                           </ul>
                        </li>
 
                        <li class="nav-item <?= (isset($_GET['pages']) && $_GET['pages'] == 'san-pham') ? 'active' : '' ?>">
                           <a class="nav-link" href="?pages=san-pham">Sản Phẩm</a>
                        </li>
 
                        <li class="nav-item">
                           <a class="nav-link" href="#">Tin Tức</a>
                        </li>
 
                        <li class="nav-item">
                           <a class="nav-link" href="#">Liên Hệ</a>
                        </li>
                     </ul>

                     <ul class="navbar_right-actions">
                        
                        <li class="nav-item <?= (isset($_GET['pages']) && $_GET['pages'] == 'gio-hang') ? 'active' : '' ?>">
                           <a class="nav-link" href="?pages=gio-hang" title="Giỏ hàng">
                              <svg class="nav-icon-svg" version="1.1" viewBox="0 0 456.029 456.029">
                                 <g><path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" /></g>
                                 <g><path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4C457.728,97.71,450.56,86.958,439.296,84.91z" /></g>
                                 <g><path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" /></g>
                              </svg>
                           </a>
                        </li>
 
                        <li class="nav-item">
                           <form class="form-inline" action="" method="GET">
                              <input type="hidden" name="pages" value="tim-kiem">
                              <button class="btn-search-trigger" type="submit" title="Tìm kiếm">
                                 <svg class="nav-icon-svg" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                                 </svg>
                              </button>
                           </form>
                        </li>
 
                        <?php if (isset($_SESSION['user'])): ?>
                           <li class="nav-item">
                              <a class="nav-link" href="?pages=ho-so">
                                 <i class="fa fa-user"></i> <?= htmlspecialchars($_SESSION['user']['name']) ?>
                              </a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="?pages=dang-xuat">Đăng Xuất</a>
                           </li>
                        <?php else: ?>
                           <li class="nav-item <?= (isset($_GET['pages']) && $_GET['pages'] == 'dang-nhap') ? 'active' : '' ?>">
                              <a class="nav-link btn-login-highlight" href="?pages=dang-nhap">Đăng Nhập</a>
                           </li>
                           <li class="nav-item <?= (isset($_GET['pages']) && $_GET['pages'] == 'dang-ky') ? 'active' : '' ?>">
                              <a class="nav-link btn-register-highlight" href="?pages=dang-ky">Đăng Ký</a>
                           </li>
                        <?php endif; ?>
 
                     </ul>
 
                  </div>
 
               </nav>
 
            </div>
 
         </header>
         