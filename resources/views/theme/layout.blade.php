<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>Notadd-基于Laravel的开源CMS/微信/商城平台</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Notadd,LaravelCMS,Laravel商城,Laravel微信,Laravel论坛">
    <meta name="description" content="Notadd是基于Laravel的一款开源CMS/商城/微信/论坛，原生支持PHP7，Notadd不仅完全面向对象，且代码简洁、优雅，是为开发者而生，也是为艺术家而存。此外，Notadd还引入了许多新的特性，诸如webp支持，更加灵活的插件模板机制，使得你可以快速构建出自己所想，使用Compeser管理相关依赖，对于一个生命周期超过3年的项目来说，Notadd再合适不过。总之，使用Notadd构建Web程序将带给开发者一场绝妙非凡的体验。">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/default/images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/default/images/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('assets/default/images/favicon-16x16.png') }}" sizes="16x16">
    <link rel="manifest" href="{{ asset('assets/default/images/manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('assets/default/images/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00a300">
    <meta name="msapplication-TileImage" content="{{ asset('assets/default/images/mstile-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('assets/default/sheets/bootstrap.min.css') }}" rel="stylesheet">
    @section('sheets')@show
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
@yield('content')
<script src="{{ asset('assets/default/scripts/jquery.1.11.3.min.js') }}"></script>
<script src="{{ asset('assets/default/scripts/bootstrap.min.js') }}"></script>
@section('script')@show
</body>