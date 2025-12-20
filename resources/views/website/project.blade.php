@extends('website.master')
@section('content')

<section class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Dự án
                </li>
            </ol>
        </nav>
    </div>
</section>

<div class="projects-section" id="projects">
        <div class="container">
            <p class="text-center text-muted mb-5">Khám phá những dự án bất động sản cao cấp với vị trí đắc địa và tiện ích hoàn hảo</p>
            
            <div class="row">
                @foreach($projects as $key => $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="project-card animate-on-scroll">
                            <div class="project-img">
                                <img src="{{ $item->avatar != '' ? asset($item->avatar->image) : asset('uploads/default.png') }}" alt="{{$item->name}}">
                                @if($key == 0)
                                    <div class="project-badge">
                                        <span class="badge bg-primary">Mới</span>
                                    </div>
                                @endif
                            </div>
                            <div class="project-info">
                                <h3 class="project-title">{{$item->name}}</h3>
                                <div class="project-location">
                                    <i class="fas fa-map-marker-alt me-2"></i>{{$item->position}}
                                </div>
                                <div class="project-price">{{$item->price}}</div>
                                <p class="mb-3">{{$item->excerpt}}</p>
                                <a href="{{route('project.detail', ['slug' => $item->slug])}}" class="btn btn-primary w-100 mt-3">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection