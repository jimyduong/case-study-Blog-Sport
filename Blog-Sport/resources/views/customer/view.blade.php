@extends('homecustomer')
@section('title', $blog->post_title)

@section('content')
    <div class="col-lg-8">
        <!-- Title -->
        <h1 class="mt-4">{{$blog->post_title}}</h1>
        <hr>
        <!-- Date/Time -->
        <p class="badge badge-primary text-wrap">
            Ngày đăng: {{$blog->updated_at}}</p><br>
        <p class="badge badge-primary text-wrap">
            Số lượt xem: {{$blog->view}}
        </p>
        <p class="badge badge-primary text-wrap">
            Số lượt like: {{$blog->like}}
        </p>
        <p class="badge badge-primary text-wrap">
            {{$blog->category->name}}
        </p>
        @if(Auth::user())
            @if(!$status)
                <p style="float: right">
                    <a href="{{route('like.blog',$blog->id)}}">
                        <button class="">Like</button>
                    </a>
                </p>
            @else
                <p style="float: right">
                    <a href="{{route('dislike.blog',$blog->id)}}">
                        <button class="">Unlike</button>
                    </a>
                </p>
            @endif
        @endif
        <hr>
        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{asset($blog->image)}}" alt="">
        <hr>
        <!-- Post Content -->
        <span class="text-justify">
            <p>
                {!! $blog->content !!}
            </p>
        </span>

        <hr>
    </div>
@endsection