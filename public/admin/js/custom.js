$( document ).ready(function() {

    // Select2
    $('.select2').select2();

    // Tinymce
    // tinymce.init({
    //     language : "vi",
    //     selector: 'textarea.tinymce',
    //     plugins: 'print preview paste importcss searchreplace autolink autoresize autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
    //     toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    //     automatic_uploads: true,
    //     images_upload_url: '/admin/tinymce/upload-image',
    //     file_picker_types: 'image',
    //     file_picker_callback: function(cb, value, meta) {
    //         var input = document.createElement('input');
    //         input.setAttribute('type', 'file');
    //         input.setAttribute('accept', 'image/*');
    //         input.onchange = function() {
    //             var file = this.files[0];

    //             var reader = new FileReader();
    //             reader.readAsDataURL(file);
    //             reader.onload = function () {
    //                 var id = 'blobid' + (new Date()).getTime();
    //                 var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
    //                 var base64 = reader.result.split(',')[1];
    //                 var blobInfo = blobCache.create(id, file, base64);
    //                 blobCache.add(blobInfo);
    //                 cb(blobInfo.blobUri(), { title: file.name });
    //             };
    //         };
    //         input.click();
    //     },
    //     templates: [
    //         {
    //             title: 'Bố cục hai cột với hình bên trái và văn bản bên phải.',
    //             description: '',
    //             content: `
    //                 <div class="template-two-columns template-border">
    //                     <div class="template-left-column">
    //                         <img src="/admin/images/tinymce-default-image.png" alt="Image" />
    //                     </div>
    //                     <div class="template-right-column">
    //                         <p>Văn bản của bạn sẽ hiển thị ở đây, bên phải hình ảnh.</p>
    //                     </div>
    //                 </div>
    //             `
    //         },
    //         {
    //             title: 'Bố cục hai cột với văn bản bên trái và hình bên phải.',
    //             description: '',
    //             content: `
    //                 <div class="template-two-columns template-border">
    //                     <div class="template-left-column">
    //                         <p>Văn bản của bạn sẽ hiển thị ở đây, bên trái hình ảnh.</p>
    //                     </div>
    //                     <div class="template-right-column">
    //                         <img src="/admin/images/tinymce-default-image.png" alt="Image" />
    //                     </div>
    //                 </div>
    //             `
    //         },
    //     ],
    //     content_css: '/admin/css/tinymce-template.css',
    // });
    initTinymce('textarea.tinymce')

    // Ajax CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Jquery validate
    $.validator.setDefaults({
        errorPlacement: function (error, element) {
            if(element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        },
    });

    // Tooltip
    $('[data-bs-toggle="tooltip"]').tooltip();
});

function initTinymce(selector) {

    let fontSizes = '';
    for(i = 8; i <= 70; i++) {
        fontSizes += i + 'px '
    }

    tinymce.init({
        language : "vi",
        selector: selector,
        plugins: 'print preview paste importcss searchreplace autolink autoresize autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
        automatic_uploads: true,
        images_upload_url: '/admin/tinymce/upload-image',
        document_base_url: '../../../', 
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function() {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        },
        templates: [
            // {
            //     title: 'Tiêu đề và nội dung (Kiểu 1)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <h3>Thiết kế kiến trúc độc đáo</h3>
            //             <p>Sunshine City được thiết kế bởi kiến trúc sư nổi tiếng người Singapore - ông Richard Hassell, với concept "Living in Nature" - sống hài hòa với thiên nhiên. Các tòa nhà được bố trí thông minh để tối ưu hóa ánh sáng tự nhiên và thông gió.</p>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Danh sách (Kiểu 1)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <h3>5 phân khu chức năng</h3>
            //             <ul>
            //                 <li><strong>Khu căn hộ cao cấp</strong> (15 tòa nhà, 32 tầng)</li>
            //                 <li><strong>Khu biệt thự song lập và đơn lập</strong></li>
            //                 <li><strong>Khu phức hợp thương mại - văn phòng</strong></li>
            //                 <li><strong>Khu tiện ích công cộng</strong></li>
            //                 <li><strong>Khu công viên và hồ điều hòa</strong></li>
            //             </ul>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Thông tin tổng quan (Kiểu 1)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <div class="stats-grid">
            //             <div class="stat-item">
            //                 <div class="stat-number">20</div>
            //                 <div class="stat-label">Diện tích tổng thể</div>
            //             </div>
            //             <div class="stat-item">
            //                 <div class="stat-number">3</div>
            //                 <div class="stat-label">Căn hộ &amp; biệt thự</div>
            //             </div>
            //             <div class="stat-item">
            //                 <div class="stat-number">15</div>
            //                 <div class="stat-label">Tòa căn hộ</div>
            //             </div>
            //             <div class="stat-item">
            //                 <div class="stat-number">40</div>
            //                 <div class="stat-label">Mật độ xây dựng</div>
            //             </div>
            //         </div>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Thông tin tổng quan (Kiểu 2)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <div class="content-grid" style="grid-template-columns: repeat(4, 1fr);">
            //                 <div class="grid-item">
            //                     <div class="transport-icon">
            //                         <i class="fas fa-subway"></i>
            //                     </div>
            //                     <div class="transport-content">
            //                         <h4>Metro số 4</h4>
            //                         <p>Ga Metro ngay cổng chính dự án, kết nối nhanh đến trung tâm thành phố</p>
            //                     </div>
            //                 </div>
                            
            //                 <div class="grid-item">
            //                     <div class="transport-icon">
            //                         <i class="fas fa-road"></i>
            //                     </div>
            //                     <div class="transport-content">
            //                         <h4>Đường vành đai 2</h4>
            //                         <p>Tiếp giáp đường vành đai 2, di chuyển đến các quận trung tâm trong 10 phút</p>
            //                     </div>
            //                 </div>
                            
            //                 <div class="grid-item">
            //                     <div class="transport-icon">
            //                         <i class="fas fa-plane"></i>
            //                     </div>
            //                     <div class="transport-content">
            //                         <h4>Sân bay Tân Sơn Nhất</h4>
            //                         <p>Chỉ 15 phút di chuyển đến sân bay quốc tế Tân Sơn Nhất</p>
            //                     </div>
            //                 </div>
                            
            //                 <div class="grid-item">
            //                     <div class="transport-icon">
            //                         <i class="fas fa-ship"></i>
            //                     </div>
            //                     <div class="transport-content">
            //                         <h4>Cảng Hi-Tech</h4>
            //                         <p>Tiếp cận cảng công nghệ cao chỉ trong 8 phút</p>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Điểm nhấn dự án (Kiểu 1)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <blockquote>
            //                 "Vị trí vàng - Kết nối đa chiều - Tiện ích vượt trội. Sunshine City mang đến cho cư dân một cuộc sống đẳng cấp ngay trung tâm thành phố."
            //             </blockquote>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Hình ảnh (Kiểu 1)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <div class="content-gallery">
            //                 <div class="gallery-item">
            //                     <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Kiến trúc hiện đại">
            //                     <div class="gallery-caption">
            //                         <h5>Kiến trúc hiện đại</h5>
            //                         <p>Thiết kế tối ưu ánh sáng</p>
            //                     </div>
            //                 </div>
            //                 <div class="gallery-item">
            //                     <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="Không gian xanh">
            //                     <div class="gallery-caption">
            //                         <h5>Không gian xanh</h5>
            //                         <p>Hài hòa với thiên nhiên</p>
            //                     </div>
            //                 </div>
            //                 <div class="gallery-item">
            //                     <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80" alt="View toàn cảnh">
            //                     <div class="gallery-caption">
            //                         <h5>View toàn cảnh</h5>
            //                         <p>Tầm nhìn thành phố</p>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Hình ảnh (Kiểu 2)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <div class="amenities-grid" style="grid-template-columns: repeat(4, 1fr);">
            //                 <div class="amenity-item" style="background-image: url('https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80');">
            //                     <div class="amenity-overlay"></div>
            //                     <div class="amenity-content">
            //                         <h4>Hồ bơi vô cực 3 tầng</h4>
            //                         <p>Hồ bơi nước mặn rộng 1.200m² với view toàn cảnh thành phố, được thiết kế theo phong cách Bali.</p>
            //                     </div>
            //                 </div>
                            
            //                 <div class="amenity-item" style="background-image: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80');">
            //                     <div class="amenity-overlay"></div>
            //                     <div class="amenity-content">
            //                         <h4>Phòng gym đa năng</h4>
            //                         <p>Phòng gym rộng 1.500m² với đầy đủ thiết bị hiện đại, phòng yoga, studio dance và spa.</p>
            //                     </div>
            //                 </div>
                            
            //                 <div class="amenity-item" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80');">
            //                     <div class="amenity-overlay"></div>
            //                     <div class="amenity-content">
            //                         <h4>Khu vui chơi trẻ em</h4>
            //                         <p>Khu vui chơi trong nhà và ngoài trời rộng 2.000m² với các trò chơi sáng tạo và an toàn.</p>
            //                     </div>
            //                 </div>
                            
            //                 <div class="amenity-item" style="background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?ixlib=rb-4.0.3&amp;auto=format&amp;fit=crop&amp;w=600&amp;q=80');">
            //                     <div class="amenity-overlay"></div>
            //                     <div class="amenity-content">
            //                         <h4>Công viên trung tâm 5ha</h4>
            //                         <p>Công viên cây xanh với hồ điều hòa, đường chạy bộ, sân thể thao và khu picnic gia đình.</p>
            //                     </div>
            //                 </div>
            //             </div>
            //         </div>
            //     `
            // },
            // {
            //     title: 'Tiến độ thi công (Kiểu 1)',
            //     description: '',
            //     content: `
            //         <div class="tinymce-content">
            //             <div class="content-timeline">
            //                 <div class="timeline-item">
            //                     <div class="timeline-date">Quý 1/2022</div>
            //                     <h4>Khởi công dự án</h4>
            //                     <p>Lễ khởi công chính thức diễn ra vào ngày 15/03/2022 với sự tham gia của lãnh đạo TP.HCM và đại diện chủ đầu tư.</p>
            //                 </div>
                            
            //                 <div class="timeline-item">
            //                     <div class="timeline-date">Quý 3/2022</div>
            //                     <h4>Hoàn thiện hạ tầng</h4>
            //                     <p>Hoàn thành 100% hệ thống hạ tầng kỹ thuật: điện, nước, viễn thông, hệ thống thoát nước và xử lý nước thải.</p>
            //                 </div>
                            
            //                 <div class="timeline-item">
            //                     <div class="timeline-date">Quý 1/2023</div>
            //                     <h4>Xây dựng phần thô</h4>
            //                     <p>Hoàn thiện phần thô 5 tòa căn hộ đầu tiên, tiến độ đạt 40% so với kế hoạch tổng thể.</p>
            //                 </div>
                            
            //                 <div class="timeline-item">
            //                     <div class="timeline-date">Quý 4/2023</div>
            //                     <h4>Hoàn thiện nội thất</h4>
            //                     <p>Bắt đầu thi công nội thất căn hộ mẫu và các tiện ích nội khu: hồ bơi, phòng gym, khu vui chơi.</p>
            //                 </div>
                            
            //                 <div class="timeline-item">
            //                     <div class="timeline-date">Quý 2/2024</div>
            //                     <h4>Bàn giao đợt 1</h4>
            //                     <p>Bàn giao 800 căn hộ đợt 1 cho khách hàng, hoàn thiện 70% tiện ích nội khu.</p>
            //                 </div>
                            
            //                 <div class="timeline-item">
            //                     <div class="timeline-date">Quý 4/2024</div>
            //                     <h4>Bàn giao toàn bộ</h4>
            //                     <p>Bàn giao toàn bộ 3.200 căn hộ và biệt thự, hoàn thiện 100% tiện ích theo cam kết.</p>
            //                 </div>
            //             </div>
            //         </div>
            //     `
            // }
        ],
        content_style: "@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');",
        content_css: '/admin/css/tinymce-template.css?v3',
        fontsize_formats: fontSizes,
        setup: function (editor) {
            editor.on('SetContent', function (e) {

                // For tabs template
                const randomID = () => `id-${Math.random().toString(36).substr(2, 9)}`;
                const container = editor.getBody();
                const tabs = container.querySelectorAll('.template-tabs');
    
                tabs.forEach(tab => {
                    const tablist = tab.querySelector('.nav');
                    const tabContents = tab.querySelector('.tab-content');
    
                    const buttons = tablist.querySelectorAll('button');
                    const panes = tabContents.querySelectorAll('.tab-pane');
    
                    buttons.forEach((button, index) => {
                        const newID = randomID();
                        button.setAttribute('data-bs-target', `#${newID}`);
                        panes[index].setAttribute('id', newID);
                    });
                });

            });
        }
    });
}

// Delete confirm messae
$(document).on('click', '.btnDelete', function(e) {
    e.preventDefault();
    var message = 'Bạn có chắc muốn xóa?';
    if (confirm(message)) {
        $(this).closest('form').submit();
    } else {
        return;
    }
})
// Keypress input number
$(document).on('keypress', 'input[type="number"]', function(e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});
// Format thoundsand numbers
function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function parseNumberFromString(string) {
    let numberString = string.replace(/[^\d]/g, '');
    let number = parseInt(numberString);
    return number;
}

// Preview image upload
$(document).on('change', 'input[type="file"]', function() {
    let inputFile = $(this)[0];
    let previewImage = $(this).next('img.preview-image');

    if (previewImage.length) {
        if (inputFile.files && inputFile.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                previewImage.attr('src', e.target.result);
                previewImage.removeClass('d-none');
            };
            reader.readAsDataURL(inputFile.files[0]);
        }
    }
});

// $('input[type="file"]').on('change', function() {

//     let inputFile = $(this)[0];
//     let previewImage = $(this).next('img.preview-image');

//     if (previewImage.length) {
//         if (inputFile.files && inputFile.files[0]) {
//             let reader = new FileReader();
//             reader.onload = function(e) {
//                 previewImage.attr('src', e.target.result);
//                 previewImage.removeClass('d-none');
//             };
//             reader.readAsDataURL(inputFile.files[0]);
//         }
//     }
// });

// Remove empty arrays
function removeEmptyArrays(attributes) {
    return attributes.filter(function(attribute) {
      return attribute.length > 0;
    });
}
// Generate variations
function generateVariations(attributes) {
    if (attributes.length === 0) {
        return [];
    }

    var currentAttribute = attributes[0];
    var remainingAttributes = attributes.slice(1);
    var remainingVariations = generateVariations(remainingAttributes);

    var variations = [];

    currentAttribute.forEach(function (value) {
        if (remainingVariations.length > 0) {
            remainingVariations.forEach(function (variation) {
                variations.push([value].concat(variation));
            });
        } else {
            variations.push([value]);
        }
    });

    return variations;
}
// Simple Hash
function simpleHash(inputString) {
    let hash = 0;
    if (inputString.length === 0) {
      return hash.toString();
    }
    for (let i = 0; i < inputString.length; i++) {
      const char = inputString.charCodeAt(i);
      hash = (hash << 5) - hash + char;
    }
    return hash.toString();
}