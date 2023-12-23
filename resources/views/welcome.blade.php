@extends('layouts.app')

@section('title','AppSorteos')
@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero" class="clearfix">
    <div class="container" data-aos="fade-up">
        <div class="hero-img" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img/hero-img.svg" alt="" class="img-fluid">
        </div>
        <div class="hero-info" data-aos="zoom-in" data-aos-delay="100">
            <h2>Bienvenidos<br><span>AppSorteos</span><br></h2>
            <div>

            </div>
        </div>
    </div>
</section><!-- End Hero Section -->
<!-- ======= About Section ======= -->
{{-- <section id="about">
    <div class="container" data-aos="fade-up">

        <header class="section-header">
            <h3>Acerca de Nosotros</h3>
            <p>Bienvenidos a nuestra plataforma de emisión de certificados de cursos</p>
        </header>

        <div class="row about-container">

            <div class="col-lg-6 content order-lg-1 order-2">
            <p>
                Nuestra Unidad de Sistemas ha desarrollado una solución eficiente y segura que permite a los estudiantes obtener sus certificados de cursos de manera sencilla a través de la búsqueda de su cédula de identidad
            </p>

            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                <div class="icon"><i class="bi bi-card-checklist"></i></div>
                <h4 class="title"><a href="">Facilitar la Obtención de Certificados</a></h4>
                <p class="description">Nuestra misión principal es simplificar el proceso de obtención de certificados de cursos para los estudiantes</p>
            </div>

            <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                <div class="icon"><i class="bi bi-brightness-high"></i></div>
                <h4 class="title"><a href="">Protegiendo su Información</a></h4>
                <p class="description">La seguridad y la privacidad son fundamentales para nosotros.</p>
            </div>

            <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                <div class="icon"><i class="bi bi-calendar4-week"></i></div>
                <h4 class="title"><a href="">Ahorro de Tiempo y Esfuerzo</a></h4>
                <p class="description">Nuestra plataforma está diseñada para proporcionar certificados de cursos de manera eficiente</p>
            </div>

            </div>

            <div class="col-lg-6 background order-lg-2" data-aos="zoom-in">
                <img src="{{asset('img/about-img.svg')}}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section> --}}
<!-- End About Section -->
    <!-- ======= Services Section ======= -->
{{-- <section id="services" class="section-bg">
    <div class="container" data-aos="fade-up">
        <header class="section-header">
            <h3>Nuestros Servicios</h3>
        </header>
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12" data-aos="zoom-in" data-aos-delay="100">
                <div class="box" style="max-width: 50rem; margin: 1rem auto;">
                    <div class="icon"><i class="fa fa-file-text-o" style="color: #fa6847;"></i></div>
                    <h4 class="title"><a href="">Generación de Certificados</a></h4>
                    <p class="description">Genera fácilmente tus certificados en línea y ahorra tiempo en el proceso de emisión.</p>
                </div>
            </div>
            <div class="col-md-12 col-lg-12" data-aos="zoom-in" data-aos-delay="200">
                <div class="box" style="max-width: 50rem; margin: 1rem auto;">
                    <div class="icon"><i class="bi bi-card-checklist" style="color: #5fe68a;"></i></div>
                    <h4 class="title"><a href="">Consulta de Certificados</a></h4>
                    <p class="description">Accede a tus certificados en cualquier momento y desde cualquier lugar.</p>
                </div>
            </div>

            <div class="col-md-12 col-lg-12" data-aos="zoom-in" data-aos-delay="100">
                <div class="box" style="max-width: 50rem; margin: 1rem auto;">
                    <div class="icon"><i class="fa fa-cogs" style="color: #57e3dc;"></i></div>
                    <h4 class="title"><a href="">Soporte 24/7</a></h4>
                    <p class="description">Nuestro equipo de soporte está disponible las 24 horas, los 7 días de la semana para ayudarte en lo que necesites.</p>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Services Section --> --}}
@endsection