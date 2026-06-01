 <!--begin::App Main-->
 <main class="app-main">
     <!--begin::App Content Header-->
     <div class="app-content-header">
         <!--begin::Container-->
         <div class="container-fluid">
             <!--begin::Row-->
             <div class="row">
                 <div class="col-sm-6">
                     <h3 class="mb-0">Simple Tables</h3>
                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-end">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active" aria-current="page">Simple Tables</li>
                     </ol>
                 </div>
             </div>
             <!--end::Row-->
         </div>
         <!--end::Container-->
     </div>
     <!--end::App Content Header-->
     <!--begin::App Content-->
     <div class="app-content">
         <!--begin::Container-->
         <div class="container-fluid">
             <!--begin::Row-->
             <div class="row">
                 <div class="col-md-12">
                     <div class="card mb-4">
                         <div class="card-header d-flex align-items-center justify-content-between">
                            Sản phẩm
                            <a href="" class="btn btn-primary">Thêm sản phẩm</a>
                         </div>
                         <!-- /.card-header -->
                         <div class="card-body">
                             <table class="table table-bordered table-striped">
                                 <thead>
                                     <tr>
                                         <th style="width: 10px">#</th>
                                         <th>Hình ảnh</th>
                                         <th>Tên sản phẩm</th>
                                         <th>Giá</th>
                                         <th>Danh mục</th>
                                         <th style="width: 40px">Hành động</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <?php for ($i = 0; $i < 10; $i++): ?>
                                         <tr class="align-middle">
                                             <td>1.</td>
                                             <td><img src="https://images2.thanhnien.vn/528068263637045248/2026/1/3/iphone-18-1767406067623415817992.png" height="40" alt=""></td>
                                             <td>Iphone 18 shopee</td>
                                             <td>
                                                 50.000đ
                                             </td>
                                             <td><span class="badge text-bg-danger">Apple</span></td>
                                             <td>
                                                 <a href="" class="btn btn-info">Xem</a><a href="" class="btn btn-warning">Sửa</a><a href="" class="btn btn-danger">Xoá</a>
                                             </td>
                                         </tr>
                                     <?php endfor; ?>
                                 </tbody>
                             </table>
                         </div>
                         <!-- /.card-body -->
                         <div class="card-footer clearfix">
                             <ul class="pagination pagination-sm m-0 float-end">
                                 <li class="page-item">
                                     <a class="page-link" href="#">&laquo;</a>
                                 </li>
                                 <li class="page-item">
                                     <a class="page-link" href="#">1</a>
                                 </li>
                                 <li class="page-item">
                                     <a class="page-link" href="#">2</a>
                                 </li>
                                 <li class="page-item">
                                     <a class="page-link" href="#">3</a>
                                 </li>
                                 <li class="page-item">
                                     <a class="page-link" href="#">&raquo;</a>
                                 </li>
                             </ul>
                         </div>
                     </div>
                     <!-- /.card -->

                 </div>
             </div>
             <!--end::Row-->
         </div>
         <!--end::Container-->
     </div>
     <!--end::App Content-->
 </main>
 <!--end::App Main-->