<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
require __DIR__ . '/includes/functions.php';

$pdo = get_db();
$requestedPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$blogData = get_blogs_paginated($pdo, $requestedPage);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Media Jungle</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="https://vsmartengine.com/assets/img/MJ/logo2.png" rel="icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://vsmartengine.com/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://vsmartengine.com/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://vsmartengine.com/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="https://vsmartengine.com/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://vsmartengine.com/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="https://vsmartengine.com/assets/css/main.css" rel="stylesheet">
  <link href="https://vsmartengine.com/assets/css/index.css" rel="stylesheet">
  <link rel="stylesheet" href="https://vsmartengine.com/assets/css/demo.css">

<link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD"
      crossorigin="anonymous"
    />

  
<style>
.hero {
  position: relative;
  background: url('https://vsmartengine.com/assets/img/MJ/hero-area.jpg') center center / cover no-repeat;
  background-attachment: fixed;
  color: white;
  padding: 120px 0;
  overflow: hidden;
  z-index: 1;
}

/* Stronger overlay for readability */
.hero::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.8); /* strong dark overlay */
  z-index: 1;
}

/* Keep content above overlay */
.hero .main-heading,
.hero .description,
.hero .btn,
.hero .fluid-shape {
  position: relative4;
  z-index: 2;
}
a{
        text-decoration: none;
      }

/* Gradient h1 with shadow */
.hero .main-heading h1 {
  
  font-family:sans-serif;


  /* 1. Start-and-end red so the loop is seamless
  background: linear-gradient(
    90deg,
    /* #fb0000,
    #e74c3c,*/
    /*#8e44ad,
    #4A6CF7,
    #27ae60,
    #2980b9,
    #8e44ad
    #3758F9
  );

  /* 2. Make the gradient four times as wide as the text mask 
  background-size: 400% 100%;

  /* 3. Clip gradient to the glyphs 
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
  -webkit-text-fill-color: transparent;

  /* 4. Smooth horizontal scroll 
  animation: gradientScroll 10s linear infinite; */
}
.navmenu ul li a {
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 1px;
      }
/* 5. Keyframes: slide the giant gradient fully past the mask */
@keyframes gradientScroll {
  0%   { background-position:   0% 50%; }
  100% { background-position: -400% 50%; }
}
/* Paragraph with bright white and shadow */
.hero .description p {
  font-size: 18px;
  color: #ffffff;
  line-height: 1.6;
  margin-bottom: 30px;
  text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
}



.hero .btn i {
  transition: transform 0.3s ease;
}

.hero .btn:hover i {
  transform: translateX(4px);
}

/* Floating animation */
.hero .fluid-shape .fluid-img {
  width: 100%;
  max-width: 400px;
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
  100% { transform: translateY(0); }
}
@media (min-width: 992px) {
  .hero .fluid-shape {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    height: 100%;
  }
}

@media (max-width: 767px) {
  .hero {
    padding: 80px 20px;
    text-align: center;
  }

  .hero .main-heading h1 {
    font-size: 32px; /* smaller headline for mobile */
    line-height: 1.3;
    margin-bottom: 16px;
  }

  .hero .description p {
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 24px;
  }

  .hero .btn {
    padding: 10px 24px;
    font-size: 15px;
  }

  .hero .fluid-shape .fluid-img {
    max-width: 300px;
    margin: 0 auto;
  }
}

/* Custom background for About section in Media Jungle with gradient
#about.section {
  background: linear-gradient(135deg, #3758F9 0%, #8ed1fc 100%) !important;
} */
</style>

</head>
<a href="https://api.whatsapp.com/send?phone=+919566191759&text=Hi" 
   class="whatsapp-float" 
   target="_blank" 
   aria-label="Chat on WhatsApp">
   <div class="whatsapp-tooltip">Chat with us</div>
  <i class="bi bi-whatsapp"></i>
</a>
<body class="index-page">

  <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/61ee87719bd1f31184d8f638/1fq5s25ru';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>

  <nav class="navbar navbar-expand-xl bg-dark fixed-top">
        <div class="logo-section px-lg-3">
            <a href="https://vsmartengine.com" class="logo d-flex align-items-center me-auto me-xl-0">
                
                <img src="https://vsmartengine.com/assets/img/product-logo/vsmartengine v2-1.png" class="navimgmov company-logo" style="" height="51px" alt="" />
                
            </a>
            <div class="vertical-line"></div>
            <a href="https://mediajungle.vsmartengine.com/" class="logo d-flex align-items-center me-auto me-xl-0"
                style="text-decoration: none">
                
                <img src="https://vsmartengine.com/assets/img/MJ/logo2.png" alt="" style="" height="51px" />
                
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg"
            aria-controls="navbarOffcanvasLg">
            <span class=""><i class="bi bi-list text-light p-3"></i></span>
        </button>
        <div class="offcanvas offcanvas-end bg-dark w-75" tabindex="-1" id="navbarOffcanvasLg"
            aria-labelledby="navbarOffcanvasLgLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                    <a href="https://vsmartengine.com/"><img src="https://vsmartengine.com/assets/img/product-logo/vsmartengine logo v2.png" height="60 " alt="" /></a>
                </h5>
                <button type="button" class="btn-close btn-close-white p-4" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start my-auto flex-grow-1 pe-3">
                    <li class="nav-item" data-bs-toggle="offcanvas" data-bs-toggle="offcanvas">
                        <a class="nav-link text-white" href="#features">Features</a>
                    </li>
                    <li class="nav-item" data-bs-toggle="offcanvas" data-bs-toggle="offcanvas">
                        <a class="nav-link text-white" href="#services">Services</a>
                    </li>
                    <li class="nav-item" data-bs-toggle="offcanvas" data-bs-toggle="offcanvas">
                        <a class="nav-link text-white" href="https://mediajungle.vsmartengine.com/pricing.html">Pricing</a>
                    </li>
                    <li class="nav-item" data-bs-toggle="offcanvas" data-bs-toggle="offcanvas">
                        <a class="nav-link text-white" href="#contact">Contact</a>
                    </li>
                  </ul>
                  <div class="nav-item p-2 d-flex justify-content-evenly align-items-start gap-3 flex-column flex-lg-row">
                      <a class="btn-getstarted mx-lg-3 bg-primary " href="https://mediajungledigital.vsmartengine.com/login">Start For Free</a>
                      <a class="btn-getstarted" href="/download.html">Download Trial</a>
                  </div>
                  <div class="social-icons d-flex align-items-center gap-3 px-xl-5 p-xl-0 p-3">
                      <a href="https://m.youtube.com/@vsmartengine"><i class="bi bi-youtube"
                              style="font-size: 1.5rem; color: red"></i></a>
                      <a href="https://x.com/vsmartengine" target="_blank"><i class="bi bi-twitter-x"
                              style="font-size: 1rem; color: white"></i></a>
                      <a href="https://www.facebook.com/people/VSmartEngine/61563355049634/" target="_blank"><i
                              class="bi bi-facebook" style="font-size: 1rem; color: blue"></i></a>
                      <a href="https://www.instagram.com/vsmartengine/#" target="_blank"><i class="bi bi-instagram"
                              style="font-size: 1rem; color: #d714b4"></i></a>
                      <a href="https://www.linkedin.com/company/vsmartengine/?viewAsMember=true" target="_blank"><i
                              class="bi bi-linkedin" style="font-size: 1rem;color: rgb(52, 37, 226);"></i></a>
                  </div>
            </div>
        </div>
    </nav>

<!--<section class="hero" id="home">
  <div class="container">
    <div class="row align-items-center">
      Text Column 
      <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center text-center text-lg-start py-5" style="margin-inline: auto;">
        <div class="main-heading">
          <h1 style="text-align: center; color: white;font-style:'poppins';">Seamless, high-quality streaming for diverse entertainment preferences</h1>
        </div>
        <div class="description">
          <p style="text-align: center;">
          -->
  <main class="main">

    <!-- Add this to your hero section -->
<section class="hero section" id="home">
  <div class="container">
    <div class="row align-items-center">
      <!-- Text Column -->
      <div class="col-lg-9 d-flex flex-column justify-content-center align-items-center text-center text-lg-start py-5" style="margin-inline: auto; ">
        <div class="main-heading">
          <h1 class="lander-heading">Seamless, high-quality streaming for diverse <span class="text-gradient">entertainment</span> preferences</h1>
        </div>
        <!-- style="margin-top: 120px;text-align: center; color: white;font-style:'Poppins';font-weight:700;font-size: 2.8rem ;line-height: 3.5rem;" -->
        <div class="description">
          <p class="lander-paragraph">
            MediaJungle OTT software offers diverse content streaming options with high performance,
            customizable settings, and user-friendly interface delivering an intuitive viewing experience.
          </p>
        </div>
        <div class="button-holder ">
          <a href="#demo" class="btn">
          Demo Page <i class="bi bi-arrow-right"></i>
          </a>
          
        </div>

      </div>

      <!-- Image Column -->
      <!--<div class="col-lg-4 d-flex justify-content-center align-items-center">
        <div class="fluid-shape">
          <img src="https://vsmartengine.com/assets/img/MJ/mj001.png" alt="Streaming Illustration" class="fluid-img" />
        </div>
      </div>-->
    </div>
  </div>
</section>


    <!-- About Section -->
    <section id="about" class="about section lp-linear-gradient"  style="color:black">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 style="color:black">About</h2>
        <div style="color:black"><span>Learn More</span> <span class="description-title">About Us</span></div>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gx-5 align-items-center">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="about-image position-relative">
              <img src="https://vsmartengine.com/assets/img/MJ/mj002.png" class="img-fluid rounded-4 shadow-sm" alt="About Image" loading="lazy">
              <!-- <div class="experience-badge">
                <span class="years">20+</span>
                <span class="text">Years of Expertise</span>
              </div> -->
            </div>
          </div>

          <div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-left" data-aos-delay="300">
  <div class="about-content">
    <h2 style="color:black">Crafted for Media Businesses & Streaming Agencies</h2>
    <p>
      MediaJungle by VsmartEngine is a cutting‑edge OTT platform tailored for creators, publishers, and agencies looking to launch seamless, branded streaming experiences.
    </p>
    <p>
      Our mission is to empower businesses with scalable, secure, and feature‑rich video streaming services—from on‑demand libraries to live events—without the complexity.
    </p>
    <div class="row g-4 mt-3">
      <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
        <div class="feature-item">
          <i class="bi bi-phone-fill" style="color: #3758f9;"></i>
          <h5 style="color:black">Intuitive Dashboard & Uploader</h5>
          <p>
            Featuring drag‑and‑drop uploads and a clean dashboard, MediaJungle simplifies video management—so you can spend less time uploading and more time publishing.
          </p>
        </div>
      </div>
      <div class="col-md-6" data-aos="zoom-in" data-aos-delay="450">
        <div class="feature-item">
          <div class="text-cont-feature-item">
            <i class="bi bi-tv-fill" style="color: #3758f9;"></i>
            <h5 style="color:black">Multi‑Device Streaming & Adaptive Quality</h5>
            <p>
              From smartphones and tablets to smart TVs and desktops, our platform adapts video quality in real time, delivering smooth HD/UHD playback across devices.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <section id="testimonial" >
        <div class="testimonial-section mt-5 pt-5" data-aos="fade-up" data-aos-delay="100">
          <div class="row">
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="200">
              <div class="testimonial-intro">
                <h3>What Our Clients Say</h3>
                <p>Discover how our solutions have empowered clients to reach new heights, transform workflows, and exceed their digital goals.</p>
                <div class="swiper-nav-buttons mt-4">
                  <button class="slider-prev"><i class="bi color:#111111 bi-arrow-left"></i></button>
                  <button class="slider-next"><i class="bi bi-arrow-right"></i></button>
                </div>
              </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="300">
              <div class="testimonial-slider swiper init-swiper" style="padding-right: 30px;" >
                <script type="application/json" class="swiper-config">
                  {
                    "loop": true,
                    "speed": 800,
                    "autoplay": {
                      "delay": 5000
                    },
                    "slidesPerView": 1,
                    "spaceBetween": 30,
                    "navigation": {
                      "nextEl": ".slider-next",
                      "prevEl": ".slider-prev"
                    },
                    "breakpoints": {
                      "768": {
                        "slidesPerView": 2
                      }
                    }
                  }
                </script>
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                      <p>"As an OTT platform owner, having full control and ownership of our content has been truly invaluable for flexibility, growth, and long-term success."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/MJ/jessica.png" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">Jessica W</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                      </div>
                      <p>"Media Jungle transformed our OTT platform with customizable features and a centralized CMS, making content management effortless."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/MJ/john.jpg" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">John D</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                      <p>"Media Jungle made it easy to integrate all our content, tools, and workflows into one seamless platform—enhancing efficiency and experience."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/MJ/alex.jpg" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">Alex P</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                      </div>
                      <p>"We chose Media Jungle because of its scalability, and it has consistently exceeded our expectations with performance and reliability."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/MJ/peter.jpg" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">Peter C</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </section> -->

          </div>
        </div>
      </div>
      
    </section><!-- /About Section -->

<section id="whyus" class="call-to-action section j1-linear-gradient">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative">

          <div class="content-left flex-grow-1" data-aos="fade-right" data-aos-delay="200">
  <span class="badge text-uppercase mb-2">Empower Your Business</span>
  <h2>Supercharge Your Streaming with<br/><span class="text-gradient"> AI-Powered </span>Precision</h2>
  <p class="my-4">
    Media Jungle’s next-gen AI transforms how you manage, recommend, and monetize content — automatically. Unlock real-time insights, intelligent recommendations, and audience-driven experiences that boost engagement and revenue.
  </p>
  

  <div class="features d-flex flex-wrap gap-3 mb-4">
    
    <div class="feature-item">
      <i class="bi bi-check-circle-fill"></i>
      <span>Next-Gen Media Intelligence Starts Here</span>
    </div>
    
  </div>

  <!-- <div class="cta-buttons d-flex flex-wrap gap-3">
    <a href="#contact" class="btn btn-primary">Purchase</a>
    <!-- <a href="service-details.html" class="btn btn-outline">Explore Products</a> --
  </div> -->
    </div>
          <div class="content-right position-relative" data-aos="fade-left" data-aos-delay="300">
            <img src="https://vsmartengine.com/assets/img/Untitled/Untitled design.png" alt="Digital Platform" class="img-fluid rounded-4">
          </div>
        </div>
      </div>
    <!-- /Call To Action Section -->

    <!-- Why Choose VsmartEngine Section -->
  <!-- <section id="why-vsmartengine" class="py-5">
  <div class="container" data-aos="fade-up">
    <div style="display:flex;justify-content: space-between;align-items: center;margin-bottom: 40px;" class="why-vsmartengine-flexer">
      <div class="mb-5">
        <h2 class="fw-regular heading section-heading">Why Choose VsmartEngine</h2>
        <p class="text" style="max-width: 400px;margin-top: 40px;font-size: 20px;line-height: 1.6;">
          VsmartEngine stands out with its user-friendly interface, customizable options, e-commerce tools, analytics, automation, and superior support—crafted to empower modern businesses with scalability, performance, and growth.
        </p>
        <div class="col-5 text30-end" style="margin-top: 40px;">
          <a class="btn-getstarted-2" style="color: #d1d5db;" href="#contact">Connect</a>
        </div>
      <!--<a class="btn-getstarted" href="#contact">Contact</a>--
      </div>
      <div>
        <img src="https://vsmartengine.com/assets/img/whyp.webp" width="500" height="400" class="why-vsmartengine-image" >
      </div>
    </div>
    <div class="row g-4">

      <div class="col-md-6 col-lg-4">
        <div class="p-4  rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-diagram-3-fill"></i>
          </div>
          <h5 class="fw-regular">Business Focused</h5>
          <p class="text small">
            Offers customizable solutions, e-commerce tools, marketing, analytics, security, and mobile responsiveness to align with your goals.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4  rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-person-check-fill"></i>
          </div>
          <h5 class="fw-regular">Customer Specific</h5>
          <p class="text small">
            Enables businesses to build and maintain strong customer relationships with automated processes and data-driven decisions.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-ui-checks-grid"></i>
          </div>
          <h5 class="fw-regular">Ready to Use</h5>
          <p class="text small">
            Prebuilt modules, templates, and scalable features allow for fast setup, easy customization, and quick deployment.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-bar-chart-line-fill"></i>
          </div>
          <h5 class="fw-regular">Faster Business Growth</h5>
          <p class="text small">
            VsmartEngine accelerates growth by improving sales efficiency, streamlining workflows, and offering scalable solutions.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-graph-up-arrow"></i>
          </div>
          <h5 class="fw-regular">Analytics and Monitoring</h5>
          <p class="text small">
            Gain insights through performance tracking, real-time analytics, and monitoring tools that drive informed decision-making.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-speedometer2"></i>
          </div>
          <h5 class="fw-regular">Highly Optimized</h5>
          <p class="text small">
            Optimized code and operations deliver fast performance, efficient processes, and minimal resource consumption.
          </p>
        </div>
      </div>

    </div>
  </div>
  </section> -->
</section>
    

    <!-- Services Section -->
    <section id="features" class="light-background services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 style="color: black;">Features</h2>
        <div><span>Check Our</span> <span class="description-title">Features</span></div>
      </div><!-- End Section Title -->

     <div class="container" data-aos="fade-up" data-aos-delay="100">

  <div class="row justify-content-center">
  
    <!-- User friendly interface -->
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
      <div class="service-card position-relative z-1">
        <div class="service-icon">
          <i class="bi bi-camera-video-fill"></i>
        </div>
        <h3>
            High-Quality Video <span>Playback</span>
        </h3>
        <p>
          Capabilities for streaming HD and UHD video content with adaptive bitrate streaming for smooth playback.
        </p>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
      <div class="service-card position-relative z-1">
        <div class="service-icon">
          <i class="bi bi-camera-video-fill"></i>
        </div>
        <h3>
            Immersive VR Experience 
        </h3>
        <p>
          Experience media like never before — step into our immersive VR world with Media Jungle.
        </p>
      </div>
    </div>

    <!-- clean design -->
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200" style="margin-bottom: 00px;">
      <div class="service-card position-relative z-1">
        <div class="service-icon">
          <i class="bi bi-collection-play-fill"></i>
        </div>
        <h3>
            Video-On-Demand
        </h3>
        <p>
          Manage a catalog of on-demand video content, movies, TV shows, documentaries, and user-generated media.
        </p>
      </div>
    </div>

    <!-- Easy to Use -->
    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
      <div class="service-card position-relative z-1">
        <div class="service-icon">
          <i class="bi bi-person-lock"></i>
        </div>
        <h3>
            Go Live with Us
        </h3>
        <p>
          Don’t miss a moment Stream your favorite shows and events live on Media Jungle.Live stream news, media, and more with zero delay
        </p>
      </div>
    </div>

  </div>
</div>


    </section><!-- /Services Section -->

    <!-- Call To Action Section -->
    <section id="services" class="call-to-action light-background section">
    <!-- Why Choose VsmartEngine Section -->
  <section id="why-vsmartengine" class="py-5">
  <div class="container" data-aos="fade-up">

    <div class="text-center mb-5">
      <h2 class="fw-bold heading">Services We Provide</h2>
    </div>

    <div class="row g-4">

      <div class="col-md-6 col-lg-4">
        <div class="p-4  rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-sliders"></i>
          </div>
          <h5 class="fw-bold">Easy to Customize</h5>
          <p class="text small">
            Designing and developing a custom OTT platform tailored to your business needs, including UI/UX design, backend development, user authentication, and integration with third-party services.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4  rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-phone"></i>
          </div>
          <h5 class="fw-bold">OTT App Development</h5>
          <p class="text small">
            Creating native mobile apps for iOS, Android, and other platforms to deliver seamless streaming experiences to users on their preferred devices, including smartphones and streaming devices.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-currency-dollar"></i>
          </div>
          <h5 class="fw-bold">Monetization Strategies</h5>
          <p class="text small">
            Implementing various monetization models such as subscription-based services, sponsorship opportunities to maximize revenue from your OTT platform.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-people"></i>
          </div>
          <h5 class="fw-bold">User Engagement &Personalization</h5>
          <p class="text small">
            Enhancing user engagement through personalized social sharing tools, user-generated content integration and user analytics.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-headset"></i>
          </div>
          <h5 class="fw-bold">Premier Support</h5>
          <p class="text small">
            Providing ongoing technical support, maintenance, updates, and enhancements to ensure the continuous operation, stability, and optimization of your OTT media software.
          </p>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="p-4 rounded-4 shadow-sm h-100">
          <div class="mb-3 text-primary fs-2">
            <i class="bi bi-clock-history"></i>
          </div>
          <h5 class="fw-bold">Universal App Support</h5>
          <p class="text small">
            Media Jungle is available on mobile, Smart TVs, Firestick, WebOS, and Google Play Store. Enjoy seamless streaming with dedicated support for every device — anytime, anywhere you watch.
          </p>
        </div>
      </div>

    </div>
  </div>
  </section>
</section>

<div class="about"><section id="testimonial"  style="background: url(https://vsmartengine.com/assets/img/bg-banner/te.webp), white;margin-top: 40px;margin-top: -100px;margin-bottom: -60px;">
        <div class="testimonial-section mt-5 pt-5" data-aos="fade-up" data-aos-delay="100">
          <div class="row">
            <div class="col-lg-4" data-aos="fade-right" data-aos-delay="200">
              <div class="testimonial-intro" style="position: relative;margin-top: -100px;margin-left: 100px;">
                <h3 style="color:white;">What Our Clients Say</h3>
                <p style="color: white;">Discover how our solutions have empowered clients to reach new heights, transform workflows, and exceed their digital goals.</p>
                <!-- <div class="swiper-nav-buttons mt-4">
                  <button class="slider-prev"><i class="bi bi-arrow-left"></i></button>
                  <button class="slider-next"><i class="bi bi-arrow-right"></i></button>
                </div> -->
              </div>
            </div>

            <div class="col-lg-8" data-aos="fade-left" data-aos-delay="300">
              <div class="testimonial-slider swiper init-swiper" style="padding-right: 30px;" >
                <script type="application/json" class="swiper-config">
                  {
                    "loop": true,
                    "speed": 800,
                    "autoplay": {
                      "delay": 5000
                    },
                    "slidesPerView": 1,
                    "spaceBetween": 30,
                    "navigation": {
                      "nextEl": ".slider-next",
                      "prevEl": ".slider-prev"
                    },
                    "breakpoints": {
                      "768": {
                        "slidesPerView": 2
                      }
                    }
                  }
                </script>
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                      <p>"Media Jungle made it easy to integrate all our content, tools, and workflows into one seamless platform—enhancing efficiency and experience."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/LH/david.jpg" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">David Miller</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                      </div>
                      <p>"As an OTT platform owner, having full control and ownership of our content has been truly invaluable for flexibility, growth, and long-term success."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/LH/sophia.jpg" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">John Abraham</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="swiper-slide">
                    <div class="testimonial-item">
                      <div class="rating mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                      </div>
                      <p>"Media Jungle transformed our OTT platform with customizable features and a centralized CMS, making content management effortless."</p>
                      <div class="client-info d-flex align-items-center mt-4">
                        <img src="https://vsmartengine.com/assets/img/LH/carlos.jpg" class="client-img" alt="Client" loading="lazy">
                        <div>
                          <h6 class="mb-0">Alex P</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section></div>
    

  <!-- demo section -->
  <section class="j1-linear-gradient section" id="demo">
  <div id="demo"  class="demo-login-container" style="margin-top: -40px;">
  <!-- Admin Demo Card -->
  <div class="demo-card admin-card">
    <div class="demo-header">
      <i class="bi bi-shield-lock"></i>
      <h3>Admin Demo</h3>
    </div>
    <div class="demo-credentials">
      <p><strong>Username:</strong> admin</p>
      <p><strong>Password:</strong> Admin@123</p>
    </div>
    <a href="https://mjdemotomcat.vsmartengine.com/admin" class="demo-button" target="_blank">Access Admin Portal</a>
  </div>

  <!-- User Demo Card -->
  <div class="demo-card user-card">
    <div class="demo-header">
      <i class="bi bi-person"></i>
      <h3>User Demo</h3>
    </div>
    <div class="demo-credentials">
      <p><strong>Username:</strong> user123@gmail.com</p>
      <p><strong>Password:</strong> User@123</p>
    </div>
    <a href="https://mjdemotomcat.vsmartengine.com/UserLogin" class="demo-button" target="_blank">Access User Portal</a>
  </div>
</div>
      <center style="margin-top: -80px;">
        <a class="btn-getstarted-2" style="color: #d1d5db;" href="#contact">Connect Us</a>
      </center>
</section>

  <section id="blog" class="j2-linear-gradient">
  <div class="container">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2 class="text-white">Blogs</h2>
      <div><span class="text-white">Check Our</span> <span class="description-title">Posts</span></div>
    </div>
    
    <!-- Blog Cards Row (dynamic: sourced from MySQL via includes/functions.php) -->
    <div class="row g-4">

      <?php if (empty($blogData['blogs'])): ?>
        <div class="col-12">
          <p class="text-white text-center">No blog posts yet. Check back soon.</p>
        </div>
      <?php else: ?>
        <?php foreach ($blogData['blogs'] as $blog): ?>
          <?php $publishDateFormatted = (new DateTime($blog['publish_date']))->format('d F, Y'); ?>
          <!-- Blog Card #<?= (int) $blog['id'] ?> -->
          <div class="col-md-4" data-aos="fade-up">
            <a href="<?= h($blog['html_file']) ?>" class="text-decoration-none">
              <div class="card h-100 shadow blog-card">
                <img src="<?= h($blog['thumbnail']) ?>" class="card-img-top" alt="<?= h($blog['title']) ?>">
                <div class="card-body">
                  <h5 class="card-title fw-bold">
                    <?= h($blog['title']) ?>
                  </h5>
                  <p class="card-text small">
                    <?= h($blog['description']) ?>
                  </p>
                  <p class="card-title fw-semibold">5 MIN READ</p>
                </div>
                <div class="card-footer small  d-flex justify-content-between">
                  <span><i class="bi bi-person-fill"></i> Posted by Admin</span>
                  <span><i class="bi bi-calendar"></i> <?= h($publishDateFormatted) ?></span>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    </div> <!-- End Row -->

    <!-- Pagination: same design language as the rest of the site -->
    <?php if ($blogData['totalPages'] > 1): ?>
      <div class="mt-4">
        <?= render_pagination($blogData['currentPage'], $blogData['totalPages'], 'index.php') ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<style>
  /* Scoped styling for the new pagination control only.
     No existing CSS file is modified -- this just keeps the
     pagination visually consistent with the site's dark/purple theme. */
  .blog-pagination .page-link {
    background-color: transparent;
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #d1d5db;
    margin: 0 4px;
    border-radius: 6px;
  }
  .blog-pagination .page-item.active .page-link {
    background-color: #7c5cff;
    border-color: #7c5cff;
    color: #fff;
  }
  .blog-pagination .page-item.disabled .page-link {
    color: #6b7280;
    border-color: rgba(255, 255, 255, 0.1);
  }
  .blog-pagination .page-link:hover {
    background-color: rgba(124, 92, 255, 0.2);
    border-color: #7c5cff;
    color: #fff;
  }
</style>



    <!-- Contact Section -->
<section id="contact" class="contact-section">

  <div class="container">
    <!-- Section Title -->
    <div class="text-center mb-5">
      <h2 class="text-white">Let’s <span class="text-primary">Connect</span></h2>
      <p class="text-white">Have a question or want to schedule a demo? Reach out anytime.</p>
    </div>

    <div class="row g-4 align-items-stretch">

      <!-- Left: Info Box -->
      <div class="col-lg-4">
        <div class="p-4 h-100 rounded-4 glass-box text-white shadow-sm d-flex flex-column justify-content-center">
          <div class="mb-3">
            <i class="bi bi-envelope-fill fs-1 text-primary"></i>
          </div>
          <h5>Email Address</h5>
          <p class="mb-1 small">Technical Support:</p>
          <a href="mailto:support@vsmartengine.com">support@vsmartengine.com</a>
          <p class="mb-1 small">Product Demo / Sales:</p>
          <a href="mailto:sales@vsmartengine.com">sales@vsmartengine.com</a>
        </div>
      </div>

      <!-- Right: Contact Form -->
      <div class="col-lg-8">

  <div class="p-4 rounded-4 glass-box text-white shadow-sm">
    <form action="https://formsubmit.co/sales@vsmartengine.com" method="POST" >
      <input type="hidden" name="_next" value="https://vsmartengine.com/">
      <div class="row g-3">
        <div class="col-md-6">
          <input type="text" name="name" class="form-control form-control-lg glass-box border-secondary text-white" style="background:transparent;" placeholder="Name" required>
        </div>
        <div class="col-md-6">
          <input type="email" name="email" class="form-control form-control-lg glass-box border-secondary text-white" style="background:transparent;" placeholder="Email Address" required>
        </div>

        <div class="col-md-12 d-flex align-items-center gap-2">
          <select name="country_code" class="form-select form-select-lg glass-box border-secondary text-light bg-dark" style="background:transparent;max-width:220px;" required>
          <option value="+1" selected>+1 (USA)</option>
            <option value="+44">+44 (UK)</option>
            <option value="+91">+91 (India)</option>
            <option value="+61">+61 (Australia)</option>
            <option value="+81">+81 (Japan)</option>
            <option value="+49">+49 (Germany)</option>
            <option value="+33">+33 (France)</option>
            <option value="+971">+971 (UAE)</option>
            <option value="+86">+86 (China)</option>
            <option value="+7">+7 (Russia)</option>
            <option value="+55">+55 (Brazil)</option>
            <option value="+27">+27 (South Africa)</option>
            <option value="+82">+82 (South Korea)</option>
            <option value="+34">+34 (Spain)</option>
            <option value="+39">+39 (Italy)</option>
            <option value="+64">+64 (New Zealand)</option>
            <option value="+65">+65 (Singapore)</option>
            <option value="+20">+20 (Egypt)</option>
            <option value="+966">+966 (Saudi Arabia)</option>
            <option value="+62">+62 (Indonesia)</option>
            <option value="+60">+60 (Malaysia)</option>
            <option value="+234">+234 (Nigeria)</option>
            <option value="+92">+92 (Pakistan)</option>
            <option value="+90">+90 (Turkey)</option>
            <option value="+48">+48 (Poland)</option>
            <option value="+31">+31 (Netherlands)</option>
            <option value="+46">+46 (Sweden)</option>
            <option value="+41">+41 (Switzerland)</option>
            <option value="+358">+358 (Finland)</option>
            <option value="+43">+43 (Austria)</option>
            <option value="+351">+351 (Portugal)</option>
            <option value="+353">+353 (Ireland)</option>
            <option value="+380">+380 (Ukraine)</option>
            <option value="+420">+420 (Czech Republic)</option>
            <option value="+45">+45 (Denmark)</option>
            <option value="+52">+52 (Mexico)</option>
            <option value="+998">+998 (Uzbekistan)</option>
            <option value="+84">+84 (Vietnam)</option>
            <option value="+66">+66 (Thailand)</option>
            <option value="+63">+63 (Philippines)</option>
            <option value="+47">+47 (Norway)</option>
            <option value="+372">+372 (Estonia)</option>
            <option value="+994">+994 (Azerbaijan)</option>
            <option value="+375">+375 (Belarus)</option>
            <option value="+380">+380 (Ukraine)</option>
            <option value="+1-876">+1-876 (Jamaica)</option>
            <option value="+1-246">+1-246 (Barbados)</option>
            <option value="+1-268">+1-268 (Antigua & Barbuda)</option>
            <option value="+1-441">+1-441 (Bermuda)</option>
            <option value="+1-473">+1-473 (Grenada)</option>
            <option value="+1-664">+1-664 (Montserrat)</option>
            <option value="+1-721">+1-721 (Sint Maarten)</option>
            <option value="+1-758">+1-758 (Saint Lucia)</option>
            <option value="+1-784">+1-784 (Saint Vincent & Grenadines)</option>
            <option value="+1-868">+1-868 (Trinidad & Tobago)</option>
            <option value="+1-876">+1-876 (Jamaica)</option>
          </select>
          <input type="text" name="phone" class="form-control form-control-lg glass-box border-secondary text-white" style="background:transparent;" placeholder="Contact Number" required>
        </div>

        <div class="col-md-12">
          <input type="text" name="subject" class="form-control form-control-lg glass-box border-secondary text-white" style="background:transparent;" placeholder="Subject" required>
        </div>
        <div class="col-md-12">
          <textarea name="message" class="form-control form-control-lg glass-box border-secondary text-white contact-form-element" style="background:transparent;" placeholder="Write Message..." rows="5" required></textarea>
        </div>
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-submit px-5 py-2">Send Message</button>
        </div>
      </div>
    </form>
  </div>

  <div class="loading">Loading</div>
  <div class="error-message"></div>
  <div class="sent-message">Your message has been sent. Thank you!</div>
</div>


    </div>
  </div>
</section>
<!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-12 footer-about" style="margin-top: 40px;">
          <a href="https://mediajungle.vsmartengine.com/" style="margin-left: 30px;" class="logo d-flex align-items-center">
            <img src="https://vsmartengine.com/assets/img/MJ/logo2.png" style="scale: 2;" alt="">
            <!-- <span class="sitename">Strategy</span> -->
          </a>
          <p>MediaJungle OTT Stream software offers diverse content streaming options with high-quality playback, customizable settings, and user-friendly interface for optimal viewing experience.</p>
          <div class="social-links d-flex mt-4">
            <a href="https://m.youtube.com/@vsmartengine"><i class="bi bi-youtube" style="font-size: 2rem; color: red;"></i></a>
        <a href="https://x.com/vsmartengine" target="_blank"><i class="bi bi-twitter-x" style="font-size:1.5rem;color:white"></i></a>
        <a href="https://www.facebook.com/people/VSmartEngine/61563355049634/" target="_blank"><i class="bi bi-facebook" style="font-size:1.5rem;color: blue;"></i></a>
        <a href="https://www.instagram.com/vsmartengine/#" target="_blank"><i class="bi bi-instagram" style="font-size:1.5rem;color: #d714b4;"></i></a>
        <a href="https://www.linkedin.com/company/vsmartengine/?viewAsMember=true" target="_blank"><i class="bi bi-linkedin" style="font-size:1.5rem;color: rgb(52, 37, 226);"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="https://vsmartengine.com">Home</a></li>
            <li><a href="https://vsmartengine.com#about">About us</a></li>
            <li><a href="https://vsmartengine.com#contact">Contact</a></li>
            <li><a href="https://vsmartengine.com/privacypolicy.html">Privacy Policy</a></li>
            <li><a href="https://vsmartengine.com/termsofservices.html">Terms of Services</a></li>
            <li><a href="https://vsmartengine.com/refundpolicy.html">Refund Policy</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-12 footer-links ">
          <h4>Our Products</h4>
          <div class="d-flex flex-row flex-wrap">

            <div class="col-6">
              <!-- AI Solutions -->
              <p class="footer-heading fw-semiregular mb-1 mt-2">AI Solutions</p>
              <ul>
                <li><a href="https://chatbot.vsmartengine.com/">ChatBot</a></li>
              </ul>

              <!-- Media -->
              <p class="footer-heading fw-semiregular mb-1 mt-2">Media & Streaming</p>
              <ul>
                <li><a href="https://mediajungle.vsmartengine.com/">MediaJungle</a></li>
              </ul>
              
            <p class="footer-heading fw-semiregular mb-1 mt-2">Automation</p>
              <ul>
                <li><a href="https://smarthome.vsmartengine.com/">SmartHome</a></li>
              </ul>
              
            <p class="footer-heading fw-semiregular mb-1 mt-2">Ecommerce</p>
              <ul>
                <li><a href="https://ecommerce.vsmartengine.com/">Ecommerce</a></li>
              </ul>
            </div>
            <div>
            <p class="footer-heading fw-semiregular mb-1 mt-2">Learning Management System</p>
            <div class="col-6">
              <!-- LearnHub Suite -->
              <p class="footer-heading fw-semiregular mb-1 mt-2">Trainer/Institute</p>
              <ul>
                <li><a href="https://learnhub.vsmartengine.com/">LearnHub</a></li>
                </ul>
            <p class="footer-heading fw-semiregular mb-1 mt-2">Corporate/Organisation</p>
            <ul>
                <li><a href="https://learnhubcorp.vsmartengine.com/">Learnhub[Corporate]</a></li>
            </ul>
            <p class="footer-heading fw-semiregular mb-1 mt-2">School Administration</p>
            <ul>
                <li><a href="https://schoolerp.vsmartengine.com/">SchoolERP</a></li>
            </ul>
              
            </div>
            </div>
            <div class="col-6">
                
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-12 footer-contact text-center text-md-start">
          <h4>Contact Us</h4>
          <a href="tel:+919566191759" class="mt-4"><strong>Phone:</strong> <span>+91 95661 91759</span></a>
          <a href="mailto:sales@vsmartengine.com"><strong>Email:</strong> <span>sales@vsmartengine.com</span></a>
        </div>

      </div>
    </div>

    <div class="container Copyright 2025 mt-4">
      <div class="d-flex justify-content-between align-items-center px-3 py-2">
        <p class="mb-0">
          © <span>Copyright 2025</span>
          <strong class="px-1 sitename">VSmartEngine</strong>
          <span>All Rights Reserved</span>
        </p>
        <p class="mb-0">Powered By Meganar Technologies</p>
      </div>
    </div>



  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="https://vsmartengine.com/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://vsmartengine.com/assets/vendor/php-email-form/validate.js"></script>
  <script src="https://vsmartengine.com/assets/vendor/aos/aos.js"></script>
  <script src="https://vsmartengine.com/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="https://vsmartengine.com/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="https://vsmartengine.com/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="https://vsmartengine.com/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="https://vsmartengine.com/assets/js/main.js"></script>
  <script src="https://vsmartengine.com/assets/js/geolocation.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://vsmartengine.com/assets/js/Payment.js"></script>

</body>

</html>