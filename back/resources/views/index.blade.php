@extends('layouts.main')

@php
    $parsedown = new Parsedown();
@endphp

@section('title')
    <title>{{ $page['title'] ?? '' }}</title>
@endsection

@section('header')
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <div><img width="100" src="{{ $header['logo'] ?? '' }}" alt=""></div>
                    <strong class="ml-2">{{ $header['title'] ?? '' }}</strong>
                </a>
                <ul class="list-unstyled d-flex mb-0">
                    @foreach($navigation ?? [] as $link)
                        <li class="ml-2"><a href="/{{ $link['slug'] }}" class="text-white">{{ $link['title'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </header>
@endsection


@section('main')
    <main role="main">
        @foreach($page['blocks'] ?? [] as $block)
            @if($block['type'] === 'text')
                <section class="jumbotron text-center mb-0">
                    <div class="container">
                        <h2>{{ $block['title'] ?? '' }}</h2>
                        {!! $parsedown->text($block['text']) !!}
                    </div>
                </section>
            @endif
            @if($block['type'] === 'google-map')
                <section class="jumbotron text-center mb-0 pb-0">
                    {{ $block['text'] }}
                </section>
                <section class="jumbotron text-center mb-0 google-map-wrap">
                    <iframe
                        height="300"
                        width="1000"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                        src="https://maps.google.com/maps?q={{ $block['latitude'] }},{{ $block['longitude'] }}&hl=us&z={{ (int) $block['zoom'] }}&amp;output=embed"
                    >
                    </iframe>
                </section>
            @endif
        @endforeach
    </main>
@endsection

@section('footer')
    <footer id="footer" class="text-muted">
        <div class="container d-flex align-items-center">
            <p class="my-4">
                Copyright © 2021 CORSNET. All Rights Reserved
            </p>
            <div class="ml-auto my-2">
                <div>{{ $footer['phone'] }}</div>
                <div>{{ $footer['email'] }}</div>
                <div>{{ $footer['address'] }}</div>
            </div>
        </div>
    </footer>
@endsection
