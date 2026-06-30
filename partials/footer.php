<!-- Footer -->
<style>
ul{
        list-style: none;
    }

    a{
        text-decoration: none;
    }
</style>
<section class="footer " >
            <footer class="py-5" style="background-color: var(--black-color);">
                <div class="container-fluid" >
                    <div class="row">
                        <div class="col-md-3">
                            <h5 class="font-weight-bold text-light">Company</h5>
                            <ul class="list-unstyled">
                                <li><a href="index.php" style="text-decoration: none;" class="text-light">Home</a></li>
                                <li><a href="about.php" style="text-decoration: none;" class="text-light">About Us</a></li>
                                <li><a href="emergency.php" style="text-decoration: none;" class="text-light">Services</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h5 class="font-weight-bold text-light">Quick Links</h5>
                            <ul class="list-unstyled">
                                <li><a href="#" style="text-decoration: none;" class="text-light">FAQ</a></li>
                                <li><a href="#" style="text-decoration: none;" class="text-light">Become a partner</a></li>
                                <li><a href="#" style="text-decoration: none;" class="text-light">Careers</a></li>
                                <li><a href="contact.php" style="text-decoration: none;" class="text-light">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h5 class="font-weight-bold text-light">Partners</h5>
                            <ul class="list-unstyled">
                                <li><a href="#" style="text-decoration: none;" class="text-light">Lagos State Government</a></li>
                                <li><a href="#" style="text-decoration: none;" class="text-light">Nigerian Police</a></li>
                                <li><a href="#" style="text-decoration: none;" class="text-light">Federal Fire Service</a></li>
                                <li><a href="#" style="text-decoration: none;" class="text-light">Federal Mistry of health</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h5 class="font-weight-bold text-light">Subscribe</h5>
                            <form action="#">
                                <div class="input-group mb-3">
                                    <input type="email" class="form-control" placeholder="email address" aria-label="Email">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" type="button">&rarr;</button>
                                    </div>
                                </div>
                            </form>
                            <p class="text-light">Subscribe to our newsletter and stay informed with everything <span class="text-danger">Eko Response</span> related. Sign up with your email address to receive news and updates.</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="col-4 d-flex align-items-center justify-content-center">
                                <span class="row align-items-center text-light">&copy; Eko Response</span>
                            </div>
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item "><a href="#" style="text-decoration: none;" class="text-light">Terms</a></li>
                                <li class="list-inline-item "><a href="#" style="text-decoration: none;" class="text-light">Privacy Policy</a></li>
                                <li class="list-inline-item "><a href="#" style="text-decoration: none;" class="text-light">Cookies</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="btn btn-link text-light"><i class="fab fa-linkedin fa-2x" aria-label="LinkedIn"></i></a>
                            <a href="https://www.facebook.com" target="_blank" rel="noopener" class="btn btn-link text-light"><i class="fab fa-facebook fa-2x" aria-label="Facebook"></i></a>
                            <a href="https://www.twitter.com" target="_blank" rel="noopener" class="btn btn-link text-light"><i class="fab fa-twitter fa-2x" aria-label="Twitter"></i></a>
                        </div>
                    </div>
                </div>
                <a href="#" class="chat-btn btn text-light" id="sticky-btn"><i class="fab fa-whatsapp "></i> Chat with us</a>
            </footer>
        </section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/static/javascript/main.js"></script>
    <script>
    const whatsappBtn = document.getElementById('sticky-btn');
    const whatsappNumber = '+1234567890'; // Replace with a real WhatsApp number

    if (whatsappBtn) {
      whatsappBtn.addEventListener('click', () => {
        window.open(`https://wa.me/${whatsappNumber}`, '_blank');
      });
    }
    </script>
</body>

</html>