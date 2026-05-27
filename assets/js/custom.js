// ✅ Fix lỗi: Cannot set properties of null (setting 'innerHTML')
// Kiểm tra element tồn tại trước khi gán
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var yearEl = document.querySelector("#displayYear");
    if (yearEl) {
        yearEl.innerHTML = currentYear;
    }
}
 
getYear();
 
 
// client section owl carousel
// ✅ Kiểm tra element tồn tại trước khi khởi tạo carousel
if ($(".client_owl-carousel").length > 0) {
    $(".client_owl-carousel").owlCarousel({
        loop: true,
        margin: 0,
        dots: false,
        nav: true,
        autoplay: true,
        autoplayHoverPause: true,
        navText: [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 2
            }
        }
    });
}
 
 
/** google_map js **/
// ✅ Kiểm tra element googleMap tồn tại trước khi load map
function myMap() {
    var mapEl = document.getElementById("googleMap");
    if (!mapEl) return;
 
    var mapProp = {
        center: new google.maps.LatLng(40.712775, -74.005973),
        zoom: 18,
    };
    var map = new google.maps.Map(mapEl, mapProp);
}