<div class="container-fluid contact-form">
    <form action="{{ route('contact') }}" method="POST" id="contactForm">
        @csrf
        <div class="row">
            <div class="col-md-6 p-0">
                <img src="{{ asset('website/images/contact-form.png') }}" class="w-100">
            </div>
            <div class="col-md-6 px-5 py-3">

                <h1 class="contact-form-title">ĐĂNG KÝ TƯ VẤN VÀ THAM QUAN TRƯỜNG</h1>
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 mb-5">
                        @foreach ($errors->all() as $error)
                            <p class="mb-1">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success border-0 mb-5">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger border-0 mb-5">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <input type="text" class="form-control" name="parent_name" placeholder="Họ tên ba mẹ">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="parent_phone" placeholder="Số điện thoại">
                </div>
                <div class="mb-3">
                    <select name="age" class="form-control">
                        <option value="">Chọn tuổi của bé</option>
                        <option value="18 - 24 Tháng">18 - 24 Tháng</option>
                        <option value="24 - 36 Tháng">24 - 36 Tháng</option>
                        <option value="3 - 4 tuổi">3 - 4 tuổi</option>
                        <option value="4 - 5 tuổi">4 - 5 tuổi</option>
                        <option value="5 - 6 tuổi">5 - 6 tuổi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select name="branch" class="form-control">
                        <option value="">Chọn chi nhánh Candles Kids</option>
                        <option value="Cơ sở 1 - Bình Thạnh">Cơ sở 1 - Bình Thạnh</option>
                        <option value="Cơ sở 2 - P17, Gò Vấp">Cơ sở 2 - P17, Gò Vấp</option>
                        <option value="Cơ sở 3 - P6, Gò Vấp">Cơ sở 3 - P6, Gò Vấp</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button class="btn btn-danger rounded-pill">ĐĂNG KÝ</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container-fluid">
    <div class="maps mt-4 mb-3">
        <div class="row">
            <div class="col-md-4">
                <h4 class="map-title">Cơ sở 1 - Bình Thạnh</h4>
                <div class="map-content">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0007197813557!2d106.69460181069583!3d10.811256058505686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528ea81a152c7%3A0xa9dc671b646314d3!2zMzkzIENodSBWxINuIEFuLCBQaMaw4budbmcgMTIsIELDrG5oIFRo4bqhbmgsIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1740492768240!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="map-title">Cơ sở 2 - P17, Gò Vấp</h4>
                <div class="map-content">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.584302221977!2d106.67291721069617!3d10.843090257915831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529ad3a90306d%3A0x2c63a8e3de1c9a00!2zNDYyIMSQLiBMw6ogxJDhu6ljIFRo4buNLCBQaMaw4budbmcgMTcsIEfDsiBW4bqlcCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1740492802155!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="map-title">Cơ sở 3 - P6, Gò Vấp</h4>
                <div class="map-content">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.501631675362!2d106.67819941069622!3d10.849399257798717!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175284cfeea9b2d%3A0xa8d41f44b96f7dd1!2zMjQgxJDGsOG7nW5nIE5ndXnhu4VuIFbEg24gRHVuZywgUGjGsOG7nW5nIDYsIEfDsiBW4bqlcCwgSOG7kyBDaMOtIE1pbmggNzI4MTAsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1740492823289!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('website/js/jquery.validate.min.js') }}"></script>
<script>

     $("#contactForm").validate({
        rules: {
            parent_name: "required",
            parent_phone: {
                required: true,
                number: true
            },
            age: {
                required: true
            },
            branch: {
                required: true
            },
        },
        messages: {
            parent_name: "Họ tên không được để trống",
            parent_phone: {
                required: "Số điện thoại không được để trống",
                number: "Số điện thoại phải là số",
            },
            age: {
                required: "Chưa chọn độ tuổi của bé",
            },
            branch: "Chưa chọn chi nhánh",
        }
    });

</script>
@endpush