<?php
require_once "partials/header.php";
?>
<style>
    /* .contact-info {
      border-bottom: 1px solid #ddd;
      padding-bottom: 15px;
      margin-bottom: 15px;
    }

    body {
    background-color: #f8f9fa;
  }

  .contact-info {
      border-bottom: 1px solid #ddd;
      padding-bottom: 15px;
      margin-bottom: 15px;
    }

    .contact-info p span {
      color: #f00;
      font-weight: bold;
    }

    .contact-icons i {
      font-size: 24px;
      margin-right: 10px;
      color: #007bff;
    } */




.text-danger {
    color: #FF0000;
}

.font-weight-bold {
    font-weight: 700;
}

.img-fluid {
    max-width: 100%;
    height: auto;
}

.container {
    /* max-width: 900px; */
}

p {
    font-size: 16px;
}

i {
    color: #2c3e50;
}

.row .col-md-4 {
    margin-bottom: 20px;
}

@media (max-width: 767.98px) {
    .col-md-4 {
        margin-bottom: 20px;
    }
}

body {
  font-family: 'Roboto', sans-serif;
}

h1 {
  font-weight: 700;
  font-size: 4rem;
}

h2 {
  font-weight: 400;
  font-size: 2rem;
}

.call-btn {
  border-radius: 20px;
  padding: 10px 30px;
}
</style>

<div class="container-fluid">
    <div class="row">
        <section class="contact-section bg-light py-5">
            <div class="">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="text-danger">CONTACT US</h2>
                        <h3 class="font-weight-bold">We want to hear from you, help us improve.</h3>
                        <p>If this is an emergency, click <strong><a href="emergency.php">Here</a></strong> immediately or submit an Emergency request via our platform by filling the <span class="text-danger">emergency form</span> on our Application.</p>
                        <div class="row mt-4">
                            <div class="col-md-4 text-center">
                                <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                                <h5 class="font-weight-bold">Pay a Visit</h5>
                                <p>5 Commercial Avenue, Sabo, Yaba, Lagos, Nigeria</p>
                            </div>
                            <div class="col-md-4 text-center">
                                
                                <i class="fas fa-phone fa-2x mb-2"></i>
                                <h5 class="font-weight-bold">Call Us</h5>
                                <p><a href="tel:+23470332896785" class="text-decoration-none text-dark">(+234)70332896785</a><br><a href="tel:+2348023078060" class="text-decoration-none text-dark">(+234)8023078060</a></p>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="fas fa-envelope fa-2x mb-2"></i>
                                <h5 class="font-weight-bold">Email Us</h5>
                                <p><a href="mailto:contact@ekoresponse.com" class="text-decoration-none text-dark">contact@<span class="text-danger">ekoresponse.com</span></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <img src="./assets/static/images/midsection.jpg" alt="Smiling Woman with Laptop" class="img-fluid img-thumbnail rounded">
                    </div>
                </div>
            </div>

            <div class="my-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <h2 class="text-center mb-4">Leave a Message</h2>
                        <p class="text-center mb-4">Contact us if you have any questions about our Platform or Services. We will respond within 24-48 hours.</p>
                        <form id="contact-form">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="tel" class="form-control" id="phoneNumber" placeholder="Phone Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" class="form-control" id="emailAddress" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="address" placeholder="Address">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="message" rows="3" placeholder="How can we help you?"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
            
        
        <section class="faq-section py-5">
            <div class="elementor-widget-container ">
                <h2 class="text-center ">FAQs</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    How does Eko Response work?
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">When a user creates an emergency alert on Eko Response, the user gets the contacts and addresses of possible <code>First Responders</code>. You will see all Police stations, fire stations, and Hospitals closest to you.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    Accordion Item #2
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Is Eko Response a non-profit organization?
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">No! We are trying to reduce response time to emergencies and provide quick access to <code>first responder</code> contacts. Our vision is to develop the platform to a level where First Responders will be notified on our app and be at the scene of your emergency in minutes.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       <section class="mid-section d-flex align-items-center my-5" style="height: 70vh; ">
    <div class="container-fluid text-light py-5" style="background-color: var(--black-color);">
                <div class="row justify-content-center">
                    <a href="tel:07003296785" class="col-md-6 text-center text-decoration-none text-light">
                        <h5>CONTACT US</h5>
                        <h2>Need help now? Call our toll free number</h2>
                        <h1 class="mb-4">0 7003 3296 785</h1>
                        <span class="btn btn-danger btn-lg call-btn">CALL US</span>
                    </a>
                </div>
            </div>
</section>
    </div>
</div>


<?php
require_once "partials/footer.php"
?>




<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#contact-form').on('submit', function(e) {
      e.preventDefault();
      // Add your form submission logic here
      // You can use AJAX to send the form data to the server
      // and handle the response accordingly
      alert('Form submitted successfully!');
      $('#contact-form')[0].reset();
    });
  });

  $(document).ready(function() {
  $('.call-btn').click(function() {
    // Simulate a call or redirect to a call service
    alert('Calling 0 8000 2255 372...');
  });
});

</script>