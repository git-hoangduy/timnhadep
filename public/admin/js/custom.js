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
            {
                title: 'Nút đăng ký ngay',
                description: '',
                content: `
                    <div class="template-container">
                        <a href="/lien-he" class="template-btn template-btn-danger template-rounded-pill btn btn-danger rounded-pill">Đăng ký ngay</a>
                    </div>
                `
            },
            {
                title: 'Nút xem thêm',
                description: '',
                content: `
                    <div class="template-container">
                        <a class="template-btn template-btn-success template-rounded-pill btn btn-success rounded-pill">Xem thêm</a>
                    </div>
                `
            },
             {
                title: 'Bố cục khung nội dung nhỏ',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-small-content template-border">Xem thêm</div>
                    </div>
                `
            },
            {
                title: 'Bố cục 3 menu tabs đều hướng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-tabs">
                            <ul class="nav nav-pills mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" type="button">Menu 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" type="button">Menu 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" type="button">Menu 3</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" tabindex="0">
                                    <h3>Tiêu đề menu 1 ...</h3>
                                    <p>Nội dung menu 1 ...</p>
                                </div>
                                <div class="tab-pane fade" tabindex="0">
                                    <h3>Tiêu đề menu 2 ...</h3>
                                    <p>Nội dung menu 2 ...</p>
                                </div>
                                <div class="tab-pane fade" tabindex="0">
                                    <h3>Tiêu đề menu 3 ...</h3>
                                    <p>Nội dung menu 3 ...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 4 menu tabs đều hướng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-tabs">
                            <ul class="nav nav-pills mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" type="button">Menu 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" type="button">Menu 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" type="button">Menu 3</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" type="button">Menu 4</button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" tabindex="0">
                                    <h3>Tiêu đề menu 1 ...</h3>
                                    <p>Nội dung menu 1 ...</p>
                                </div>
                                <div class="tab-pane fade" tabindex="0">
                                    <h3>Tiêu đề menu 2 ...</h3>
                                    <p>Nội dung menu 2 ...</p>
                                </div>
                                <div class="tab-pane fade" tabindex="0">
                                    <h3>Tiêu đề menu 3 ...</h3>
                                    <p>Nội dung menu 3 ...</p>
                                </div>
                                <div class="tab-pane fade" tabindex="0">
                                    <h3>Tiêu đề menu 4 ...</h3>
                                    <p>Nội dung menu 4 ...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 2 cột 1 dòng, tỉ lệ 2:1',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-2-1-s">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2-1-e">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 2 cột 1 dòng, tỉ lệ 1:2',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-1-2-s">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-1-2-e">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 2 cột 1 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 3 cột 1 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 4 cột 1 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-4">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-4">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-4">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-4">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 2 cột 2 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 2 cột 3 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 2 cột 4 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-2">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 3 cột 2 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                       <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 3 cột 3 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                       <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
            {
                title: 'Bố cục 3 cột 4 dòng',
                description: '',
                content: `
                    <div class="template-container">
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                       <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                        <div class="template-row">
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                            <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                             <div class="template-column template-border template-column-3">
                                <p>Nhập nội dung ...</p>
                            </div>
                        </div>
                    </div>
                `
            },
        ],
        content_css: '/admin/css/tinymce-template.css?v=20250222',
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