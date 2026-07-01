<?php
require_once __DIR__ . '/partials/auth.php';
require_once "partials/header.php";
?>

<!-- ============ HERO ============ -->
<section class="er-hero">
    <div class="container">
        <div class="col-lg-8">
            <span class="er-chip"><i class="fa-solid fa-bolt text-warning"></i> Rapid emergency response for Lagos &amp; beyond</span>
            <h1 class="mt-3">When every second counts, help is one tap away.</h1>
            <p class="lead mt-3">Report a medical, fire, accident, crime or rescue emergency, pin the exact
                location, and we route it to the nearest responders and the responsible agency — anywhere in Nigeria.</p>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a href="emergency.php" class="btn btn-brand btn-lg fw-semibold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Report an Emergency</a>
                <a href="tel:112" class="btn btn-outline-light btn-lg"><i class="fa-solid fa-phone me-1"></i> Call 112</a>
                <?php if ($loggedIn): ?>
                    <a href="user_dashboard.php" class="btn btn-light btn-lg">My Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ============ STATS BAND ============ -->
<section class="er-stats-band py-4">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3"><div class="num">24/7</div><div class="lbl">Always available</div></div>
            <div class="col-6 col-md-3"><div class="num">4+</div><div class="lbl">Response services</div></div>
            <div class="col-6 col-md-3"><div class="num">150+</div><div class="lbl">Response units</div></div>
            <div class="col-6 col-md-3"><div class="num">Nationwide</div><div class="lbl">State coverage</div></div>
        </div>
    </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="er-section">
    <div class="container">
        <div class="text-center er-section-head mb-5">
            <span class="er-eyebrow">How it works</span>
            <h2>Help in three simple steps</h2>
            <p>From the moment you report, we get the right responders moving toward you.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="er-step">
                    <div class="er-icon-badge"><i class="fa-solid fa-pen-to-square"></i></div>
                    <h5>1. Report &amp; pin</h5>
                    <p class="text-muted mb-0">Describe the emergency, choose the type, and drop a pin on the map so responders know exactly where to go.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="er-step">
                    <div class="er-icon-badge"><i class="fa-solid fa-route"></i></div>
                    <h5>2. Smart dispatch</h5>
                    <p class="text-muted mb-0">We route it to the responsible agency and every service it needs — police, medical, fire or road safety.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="er-step">
                    <div class="er-icon-badge"><i class="fa-solid fa-heart-pulse"></i></div>
                    <h5>3. Track to resolution</h5>
                    <p class="text-muted mb-0">Follow live status updates on your dashboard until the incident is resolved, then share feedback.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ SERVICES ============ -->
<section class="er-section" style="background:#fff;">
    <div class="container">
        <div class="text-center er-section-head mb-5">
            <span class="er-eyebrow">Our services</span>
            <h2>One platform, every emergency</h2>
            <p>Report any incident — we connect you to the right first responders.</p>
        </div>
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="er-service text-center">
                    <div class="er-icon-badge mx-auto"><i class="fa-solid fa-truck-medical"></i></div>
                    <h5>Medical &amp; Ambulance</h5>
                    <p class="er-tag mb-0">Injuries, collapse, casualties</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="er-service text-center">
                    <div class="er-icon-badge mx-auto"><i class="fa-solid fa-fire"></i></div>
                    <h5>Fire &amp; Rescue</h5>
                    <p class="er-tag mb-0">Fire, flood, gas leak, collapse</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="er-service text-center">
                    <div class="er-icon-badge mx-auto"><i class="fa-solid fa-shield-halved"></i></div>
                    <h5>Police &amp; Security</h5>
                    <p class="er-tag mb-0">Theft, assault, kidnapping</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="er-service text-center">
                    <div class="er-icon-badge mx-auto"><i class="fa-solid fa-car-burst"></i></div>
                    <h5>Road Safety</h5>
                    <p class="er-tag mb-0">Accidents, crashes, obstructions</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section class="er-section">
    <div class="container">
        <div class="text-center er-section-head mb-5">
            <span class="er-eyebrow">Stories</span>
            <h2>Lives changed in Lagos</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="er-quote">
                    <div class="stars mb-2">★★★★★</div>
                    <p>"My colleague collapsed during a meeting. I checked Eko Response, found the closest hospital in minutes, and we got her help immediately."</p>
                    <div class="who">Tola A.</div><div class="where">Ikeja, Lagos</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="er-quote">
                    <div class="stars mb-2">★★★★★</div>
                    <p>"I needed an ambulance and couldn't reach one. I searched online, your platform popped up, and I was amazed how smooth it was."</p>
                    <div class="who">Mrs Kolajo</div><div class="where">Lekki, Lagos</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="er-quote">
                    <div class="stars mb-2">★★★★★</div>
                    <p>"In a place where emergency help can be hard to find, Eko Response is a breath of fresh air. Fast and reliable."</p>
                    <div class="who">Oluwafemi</div><div class="where">Somolu, Lagos</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="pb-5">
    <div class="container">
        <div class="er-cta p-5 text-center">
            <h2 class="mb-2">Be ready before an emergency strikes.</h2>
            <p class="mb-4 opacity-75">Create a free account so your details are ready the moment you need to report.</p>
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <?php if ($loggedIn): ?>
                    <a href="emergency.php" class="btn btn-light btn-lg fw-semibold">Report an Emergency</a>
                <?php else: ?>
                    <a href="login_signup.php?form=signup" class="btn btn-light btn-lg fw-semibold">Create free account</a>
                    <a href="login_signup.php" class="btn btn-outline-light btn-lg">Sign in</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once "partials/footer.php"; ?>
