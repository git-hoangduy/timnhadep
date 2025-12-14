@extends('website.master')
@section('content')

<div class="breadcrumbs bg-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="bread"><span><a href="{{ route('home') }}">Trang chủ</a></span> / <span>{{ $product->name }}</span></p>
            </div>
        </div>
    </div>
</div>

<div class="colorlib-product bg-white">
    <div class="container">
        <div class="row row-pb-lg product-detail-wrap">
            <div class="col-sm-6">
                <div class="owl-carousel">
                    @if($product->images->count())
                        @foreach($product->images as $image)
                            <div class="item">
                                <div class="product-entry">
                                    <a href="#" class="prod-img">
                                        <img src="{{ asset($image->image) }}" class="img-fluid" alt="{{ $product->name }}">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                <div class="product-desc">
                    <h3>{{ $product->name }}</h3>
                    <p class="price">
                        <span>{{ number_format($product->price) }} đ</span> 
                        <!-- <span class="rate">
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-half"></i>
                            (74 Rating)
                        </span> -->
                    </p>
                    <p>{{ $product->excerpt }}</p>

                    <div class="size-wrap">
                        @php
                            $productAttrs = json_decode($product->attributes ?? '');
                        @endphp
                        @if(!empty($productAttrs))
                            @foreach($productAttrs as $key => $attr)
                            <div class="block-26 mb-2">
                                <h4>{{ $attr->name }}</h4>
                                @if(!empty($attr->values))
                                    <div class="radios-attribute">
                                    @foreach($attr->values as $key2 => $value)
                                        @if ($attr->type == 1)
                                            <div>
                                                <input type="radio" id="cb-{{$key}}-{{ $key2 }}" name="attr[{{ $key }}]" value="{{ $attr->id }}_{{ $value->id }}" class="product-attribute">
                                                <label for="cb-{{$key}}-{{ $key2 }}">
                                                    <span style="background-color: #a9a9a9">
                                                        <p>{{ $value->text }}</p>
                                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked" />
                                                    </span>
                                                </label>
                                            </div>
                                        @else
                                            <div>
                                                <input type="radio" id="cb-{{$key}}-{{ $key2 }}" name="attr[{{ $key }}]" value="{{ $attr->id }}_{{ $value->id }}" class="product-attribute">
                                                <label for="cb-{{$key}}-{{ $key2 }}" data-toggle="tooltip" data-placement="bottom" title="{{ $value->text }}">
                                                    <span style="background-color: {{ $value->color }}">
                                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/242518/check-icn.svg" alt="Checked" />
                                                    </span>
                                                </label>
                                            </div>
                                        @endif 
                                    @endforeach
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <form action="{{ route('cart.buynow') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="input-group mb-4 pt-3">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn"  data-type="minus" data-field="">
                                    <i class="icon-minus2"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="input-number" value="1" min="1" max="100">
                            <span class="input-group-btn ml-1">
                                <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                    <i class="icon-plus2"></i>
                                </button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary d-inline-block btn-addtocart">
                                    <i class="icon-shopping-cart d-inline-block"></i> Thêm vào giỏ
                                </button>
                                <button type="submit" class="btn btn-primary d-inline-block btn-buynow">
                                    <i class="icon-heart-outline d-inline-block"></i> Mua luôn
                                </button>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <ul>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="row mt-5">
                            <div class="col-md-4">
                                <span class="badge badge-pill badge-info copyLink py-2 px-3" data-url="{{ route('product.detail', $product->slug) }}"><i class="icon icon-link"></i> Sao chép liên kết</span>
                                <small class="mt-2 copyMgs text-success d-block "></small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @if($product->description != '')
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-12 pills">
                        <div class="bd-example bd-example-tabs">
                          <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                            <li class="nav-item">
                              <a class="nav-link" id="pills-description-tab" data-toggle="pill" href="#pills-description" role="tab" aria-controls="pills-description" aria-expanded="true">Mô tả sản phẩm</a>
                            </li>
                            <!-- <li class="nav-item">
                              <a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill" href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer" aria-expanded="true">Manufacturer</a>
                            </li> -->
                            <li class="nav-item">
                              <a class="nav-link active" id="pills-review-tab" data-toggle="pill" href="#pills-review" role="tab" aria-controls="pills-review" aria-expanded="true">Review</a>
                            </li>
                          </ul>

                          <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane border fade" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">
                                {!! $product->description !!}
                            </div>

                            <!-- <div class="tab-pane border fade" id="pills-manufacturer" role="tabpanel" aria-labelledby="pills-manufacturer-tab">
                              <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                                <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane. Pityful a rethoric question ran over her cheek, then she continued her way.</p>
                            </div> -->

                            <div class="tab-pane border fade show active" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                              <div class="row">
                                   <div class="col-md-8">
                                        <div id="comments">
                                            <div class="row">
                                                <div class="col-2">
                                                    @if(Auth::check())
                                                        <div class="review-user-info">
                                                            @php
                                                                $user = Auth::guard('customer')->user();
                                                            @endphp
                                                            <img src="{{ $user->avatar }}" width="30" height="30" class="align-middle rounded-circle mr-2">
                                                            <span>{{ $user->name }}</span>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('user.login') }}" class="btn btn-primary">Đăng nhập</a>
                                                    @endif
                                                </div>
                                                @if(Auth::check())
                                                    <div class="col-10 text-right">
                                                    <div class="rate">
                                                        <input type="radio" id="star5" class="rate" name="rating" value="5" checked/>
                                                        <label for="star5" title="text">5 stars</label>
                                                        <input type="radio" id="star4" class="rate" name="rating" value="4"/>
                                                        <label for="star4" title="text">4 stars</label>
                                                        <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                                                        <label for="star3" title="text">3 stars</label>
                                                        <input type="radio" id="star2" class="rate" name="rating" value="2">
                                                        <label for="star2" title="text">2 stars</label>
                                                        <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                                                        <label for="star1" title="text">1 star</label>
                                                    </div>
                                                    </div>
                                                @endif
                                             </div>
                                             @if(Auth::check())
                                                <div class="mt-2">
                                                    <textarea class="form-control" name="comment" rows="2" placeholder="Nhập bình luận của bạn" maxlength="500" required></textarea>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-default" id="submitReview">Bình luận</button>
                                                </div>
                                             @endif
                                        </div>
                                       <h3 class="head">23 Reviews</h3>
                                       <div class="reviews-list"></div>
                                       <div class="review-item d-none">
                                            <div class="review">
                                                <div class="user-img" style="background-image: url(images/person1.jpg)"></div>
                                                <div class="desc">
                                                    <h4>
                                                        <span class="text-left user-name"></span>
                                                        <span class="text-right created-at"></span>
                                                    </h4>
                                                    <p class="star">
                                                        <span>
                                                            <i class="icon-star-empty"></i>
                                                            <i class="icon-star-empty"></i>
                                                            <i class="icon-star-empty"></i>
                                                            <i class="icon-star-empty"></i>
                                                            <i class="icon-star-empty"></i>
                                                        </span>
                                                        <span class="text-right"><a href="#" class="reply"><i class="icon-reply"></i></a></span>
                                                    </p>
                                                    <p class="comment"></p>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="rating-wrap">
                                           <h3 class="head">Give a Review</h3>
                                           <div class="wrap">
                                               <p class="star">
                                                   <span>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       (98%)
                                                   </span>
                                                   <span>20 Reviews</span>
                                               </p>
                                               <p class="star">
                                                   <span>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-empty"></i>
                                                       (85%)
                                                   </span>
                                                   <span>10 Reviews</span>
                                               </p>
                                               <p class="star">
                                                   <span>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-empty"></i>
                                                       <i class="icon-star-empty"></i>
                                                       (70%)
                                                   </span>
                                                   <span>5 Reviews</span>
                                               </p>
                                               <p class="star">
                                                   <span>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-empty"></i>
                                                       <i class="icon-star-empty"></i>
                                                       <i class="icon-star-empty"></i>
                                                       (10%)
                                                   </span>
                                                   <span>0 Reviews</span>
                                               </p>
                                               <p class="star">
                                                   <span>
                                                       <i class="icon-star-full"></i>
                                                       <i class="icon-star-empty"></i>
                                                       <i class="icon-star-empty"></i>
                                                       <i class="icon-star-empty"></i>
                                                       <i class="icon-star-empty"></i>
                                                       (0%)
                                                   </span>
                                                   <span>0 Reviews</span>
                                               </p>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                            </div>

                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
@push('scripts')
<script>
    loadReviews($('input[name="product_id"]').val());
</script>
@endpush