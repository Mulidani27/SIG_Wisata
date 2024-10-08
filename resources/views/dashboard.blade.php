@extends('app')

@section('title', 'Data Wisata')

@section('content')
    <header class="bg-primary-gradient">
        <div class="container pt-4 pt-xl-5">
            <div class="row pt-5">
                <div class="col-md-8 col-xl-6 text-center text-md-start mx-auto">
                    <div class="text-center">
                        <p class="fw-bold text-success mb-2"></p>
                        <h1 class="fw-bold" style="font-size: 50px;">Sistem Informasi Geografi</h1>
                        <h1 class="fw-bold">Wisata Di Banjarmasin</h1>
                    </div>
                </div>
                <div class="col-12 col-lg-10 mx-auto">
                    <div class="position-relative" style="display: flex;flex-wrap: wrap;justify-content: flex-end;">
                        <div style="position: relative;flex: 0 0 45%;transform: translate3d(-15%, 35%, 0);"><img class="img-fluid" data-bss-parallax="" data-bss-parallax-speed="0.8" src="{{asset('')}}assets/images/menara.jpg"></div>
                        <div style="position: relative;flex: 0 0 45%;transform: translate3d(-5%, 20%, 0);"><img class="img-fluid" data-bss-parallax="" data-bss-parallax-speed="0.4" src="{{asset('')}}assets/images/bekantan.jpg"></div>
                        <div style="position: relative;flex: 0 0 65%;transform: translate3d(0, 0%, 0);"><img class="img-fluid" data-bss-parallax="" data-bss-parallax-speed="0.25" src="{{asset('')}}assets/images/bromo.jpg"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Tentang Kami</p>
                    <h2 class="fw-bold"><strong>Mengenal Website Pemetaan Wisata Kota Banjarmasin</strong></h2>
                    <p class="text-muted">Website ini adalah sistem informasi geografis yang bertujuan untuk mempermudah masyarakat dan wisatawan dalam menemukan dan mengakses informasi mengenai tempat-tempat wisata di Kota Banjarmasin.</p>
                </div>
            </div>
            <div class="row">
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start h-100">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4 flex-grow-1">
                            Dengan fitur peta interaktif, pengguna dapat menjelajahi berbagai destinasi wisata, mulai dari wisata alam, budaya, hingga kuliner yang ada di Banjarmasin. Kami percaya bahwa dengan informasi yang tepat, setiap orang dapat menemukan pengalaman wisata yang menyenangkan.
                        </p>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start h-100">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4 flex-grow-1">
                            Kami juga berkomitmen untuk memberikan informasi yang akurat dan terkini mengenai masing-masing objek wisata, sehingga pengunjung dapat merencanakan perjalanan mereka dengan lebih baik. 
                        </p>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start h-100">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4 flex-grow-1">
                            Kami berharap, melalui website ini, Anda dapat menemukan tempat wisata yang sesuai dengan minat Anda dan menjadikan kunjungan Anda ke Banjarmasin lebih berarti.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
        <section id="kontak-kami" class="kontak-kami">
            <h2>Kontak Kami</h2>
            <div class="container mt-5">
                <div class="row">
                    <div class="container mt-5">
                        <div class="row justify-content-center">
                            <div class="col-auto text-center">
                                <a href="https://www.facebook.com/YourPage" target="_blank" class="d-block mb-3">
                                    <img src="https://img.icons8.com/?size=100&id=118497&format=png&color=000000" alt="Facebook" style="width: 100px; height: 100px;">
                                    <span class="d-block">Facebook</span>
                                </a>
                            </div>
                            <div class="col-auto text-center">
                                <a href="https://www.instagram.com/YourProfile" target="_blank" class="d-block mb-3">
                                    <img src="https://img.icons8.com/?size=100&id=32323&format=png&color=000000" alt="Instagram" style="width: 100px; height: 100px;">
                                    <span class="d-block">Instagram</span>
                                </a>
                            </div>
                            <div class="col-auto text-center">
                                <a href="https://twitter.com/YourProfile" target="_blank" class="d-block mb-3">
                                    <img src="https://img.icons8.com/?size=100&id=13963&format=png&color=000000" alt="Twitter" style="width: 100px; height: 100px;">
                                    <span class="d-block">Twitter</span>
                                </a>
                            </div>
                            <div class="col-auto text-center">
                                <a href="https://www.youtube.com/YourChannel" target="_blank" class="d-block mb-3">
                                    <img src="https://img.icons8.com/?size=100&id=19318&format=png&color=000000" alt="YouTube" style="width: 100px; height: 100px;">
                                    <span class="d-block">YouTube</span>
                                </a>
                            </div>
                            <div class="col-auto text-center">
                                <a href="https://wa.me/YourNumber" target="_blank" class="d-block mb-3">
                                    <img src="https://img.icons8.com/?size=100&id=16713&format=png&color=000000" alt="WhatsApp" style="width: 100px; height: 100px;">
                                    <span class="d-block">WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </section>
        

    <section>
        <div class="container bg-primary-gradient py-5">
            <div class="row">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Partner Kami</p>
                    <h3 class="fw-bold">Logo Instansi Kami</h3>
                </div>
            </div>
            <div class="py-5 p-lg-5">
                <div class="row row-cols-1 row-cols-md-2 mx-auto" style="max-width: 900px;">
                    <div class="col mb-5">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                                <img src="path/to/logo1.png" alt="Logo 1" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                                <img src="path/to/logo2.png" alt="Logo 2" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                                <img src="path/to/logo3.png" alt="Logo 3" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex justify-content-center align-items-center" style="height: 200px;">
                                <img src="path/to/logo4.png" alt="Logo 4" class="img-fluid" style="max-width: 100%; max-height: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Testimoni</p>
                    <h2 class="fw-bold"><strong>Apa Kata Mereka Tentang Kami</strong></h2>
                    <p class="text-muted">Tidak peduli proyeknya, tim kami dapat menanganinya.&nbsp;</p>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 d-sm-flex justify-content-sm-center">
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4 equal-height">
                            Website ini telah membantu banyak wisatawan dan masyarakat lokal menemukan informasi terkini mengenai tempat-tempat wisata di Kota Banjarmasin.
                        </p>
                        <div class="d-flex">
                            <img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50" height="50" src="https://img.icons8.com/?size=100&id=13042&format=png&color=000000" alt="Gambar Animasi User">
                            <div>
                                <p class="fw-bold text-primary mb-0">Yogie Prayoga</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4 equal-height">
                            Dengan informasi yang akurat, kami yakin pengunjung dapat merencanakan perjalanan mereka dengan lebih baik.
                        </p>
                        <div class="d-flex">
                            <img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50" height="50" src="https://img.icons8.com/?size=100&id=13042&format=png&color=000000" alt="Gambar Animasi User">
                            <div>
                                <p class="fw-bold text-primary mb-0">Futra</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="d-flex flex-column align-items-center align-items-sm-start">
                        <p class="bg-body-tertiary border rounded border-0 border-light p-4 equal-height">
                            Saya menemukan banyak destinasi menarik yang sebelumnya tidak saya ketahui. Terima kasih atas informasi yang diberikan!
                        </p>
                        <div class="d-flex">
                            <img class="rounded-circle flex-shrink-0 me-3 fit-cover" width="50" height="50" src="https://img.icons8.com/?size=100&id=13042&format=png&color=000000" alt="Gambar Animasi User">
                            <div>
                                <p class="fw-bold text-primary mb-0">Fahmi Ridhani</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
  
   
    @endsection