<?php
require_once "partials/header.php"
?>
<style>
 .hero-section {
            background: url('path-to-your-background-image.jpg') no-repeat center center;
            background-size: cover;
            color: #333;
            padding: 100px 0;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.5);
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .quote-section {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }

        .hero-section .container img {
            border-radius: 8px;
        }

        .quote-section h5 {
            color: #dc3545;
        }

        .quote-section p {
            font-style: italic;
        }

        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

body {
  font-family: 'Roboto', sans-serif;
}

.card {
  border: none;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.card-img-top {
  border-radius: 50%;
  width: 150px;
  height: 150px;
  object-fit: cover;
  margin: 20px auto;
}

.card-title {
  font-weight: 700;
  margin-bottom: 5px;
}

.card-text {
  color: #666;
  margin-bottom: 15px;
}

.social-icons a {
  color: #333;
  margin: 0 5px;
  transition: color 0.3s;
}

.social-icons a:hover {
  color: #007bff;
}

</style>
<div class="container-fluid">
    <div class="row">
        <section class="hero-section">
    <div class="container hero-content">
        <h2>About Eko Response</h2>
        <h1 class="display-4">Powering Emergency Response across Lagos State</h1>
        <p>Eko Response was launched to address the thousands of preventable deaths around the state that happen every year. I grew tired of the stories of lives lost fathers, mothers, sons, and daughters valuable members of our families, properties and societies who could have been saved with timely emergency response.</p>
        <div class="row">
            <div class="col-md-6">
                <img src="./assets/static/images/ceo.jpeg" alt="Person Image" class="img-fluid shadow-lg p-1">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <div class="quote-section">
                    <h5>Abiola Aderibigbe</h5>
                    <p>We all deserve to live in a world where help is available whenever and wherever you need it. Eko Response is making this a reality.</p>
                    <small class="text-muted">Founder & CEO</small>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container my-5">
    <div class="row">
      <div class="col-md-12">
        <h3 class="text-center mb">Creating a Medium for quick access to Emergency response </h3>
        <p>Eko Response  is an Emergency technology company that is transforming the way emergencies are managed in Lagos, beginning with Lagos State. With a large database of First Responders, Police Stations, emergency vehicles like ambulances, and verified Emergency-Ready hospitals across Lagos, we connect emergency victims to the help they need 24/7. With a vision to ease access to emergency in Nigeria. <a href="#">Learn more about our Vision</a></p>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-12 ">
        <img src="./assets/static/images/login_image.jpeg" alt="Person Image" class="img-fluid  img-thumbnail shadow-lg p-3">
      </div>
    </div>
  </div>
</section>

<section class="team-section">
  <div class="container my-5">
    <div class="row justify-content-center mb-4">
      <div class="col-md-8">
        <h3 class="text-center">The Management Team</h3>
        <p class="text-center">Eko Response is a company of diverse thinkers and doers who take pride in always improving our product. We share a vision and commitment to help each other – and our customers – create great work.</p>
        <p class="text-center">Meet the team that's transforming Eko Response</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card-deck">
          <div class="card">
            <img src="./assets/static/images/ceo.jpeg" class="card-img-top" alt="Team Member 1">
            <div class="card-body text-center">
              <h5 class="card-title">Abiola Aderibigbe</h5>
              <p class="card-text">Founder &amp; CEO</p>
              <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
          <div class="card">
            <img src="./assets/static/images/testimonial2.png" class="card-img-top" alt="Team Member 2">
            <div class="card-body text-center">
              <h5 class="card-title">Habeeb Igiekpeme</h5>
              <p class="card-text">Chief Technology Officer</p>
              <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
          <div class="card">
            <img src="./assets/static/images/testimonial1.jpeg" class="card-img-top" alt="Team Member 3">
            <div class="card-body text-center">
              <h5 class="card-title">Idoreyin Jonah</h5>
              <p class="card-text">Chief Marketing Officer</p>
              <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-5">
      <div class="col-md-10">
        <div class="card-deck">
          <div class="card">
            <img src="./assets/static/images/Amanda-Nwachukwu.jpeg" class="card-img-top" alt="Team Member 4">
            <div class="card-body text-center">
              <h5 class="card-title">Arc Amanda Nwachukwu</h5>
              <p class="card-text">Principal Lead</p>
              <div class="social-icons">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
          <div class="card">
            <img src="./assets/static/images/adesewa.jpeg" class="card-img-top" alt="Team Member 5">
            <div class="card-body text-center">
              <h5 class="card-title">Adesewa Ogunmekpon</h5>
              <p class="card-text">Head of Business Development</p>
              <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
          <div class="card">
            <img src="./assets/static/images/hussein.jpeg" class="card-img-top" alt="Team Member 6">
            <div class="card-body text-center">
              <h5 class="card-title">Hussein Abdulrahman</h5>
              <p class="card-text">Lead Engineer</p>
              <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

    </div>
    
</div>

































<?php
require_once "partials/footer.php";
?>