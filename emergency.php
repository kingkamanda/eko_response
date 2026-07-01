<?php
require_once __DIR__ . '/partials/auth.php';
require_once "partials/header.php";
?>
<style>
    .em-tile { border:1px solid var(--er-line); border-radius:var(--er-radius); padding:1.5rem 1rem; text-align:center;
               background:#fff; transition:transform .2s, box-shadow .2s; height:100%; text-decoration:none; color:inherit; display:block; }
    .em-tile:hover { transform:translateY(-4px); box-shadow:var(--er-shadow); border-color:var(--er-primary); }
    .em-tile i { font-size:2rem; color:var(--er-primary); }
    .drill-bell { width:110px;height:110px;border-radius:50%; font-size:2.4rem; }
    @keyframes shake { 0%,100%{transform:translateX(0)} 25%{transform:translateX(-6px)} 50%{transform:translateX(6px)} 75%{transform:translateX(-6px)} }
    .shake { animation: shake .5s; }
</style>

<!-- ==== Report CTA ==== -->
<section class="er-section" style="background:#fff;">
    <div class="container text-center">
        <span class="er-eyebrow">Emergency</span>
        <h1 class="fw-bold mt-2">Report an emergency</h1>
        <p class="text-muted mx-auto" style="max-width:38rem;">Tell us what's happening and where. We'll dispatch the
            right responders — and if there are injuries or a weapon involved, we automatically alert medical and police too.</p>
        <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
            <a href="emergency_form.php" class="btn btn-brand btn-lg fw-semibold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Start a report</a>
            <a href="tel:112" class="btn btn-outline-danger btn-lg"><i class="fa-solid fa-phone me-1"></i> Call 112</a>
        </div>
        <?php if (!$loggedIn): ?>
            <p class="small text-muted mt-2">You'll be asked to sign in so responders can reach you.</p>
        <?php endif; ?>
    </div>
</section>

<!-- ==== Choose a type ==== -->
<section class="er-section">
    <div class="container">
        <div class="text-center er-section-head mb-4">
            <h2>What kind of emergency?</h2>
            <p>Pick the closest match — you can add detail on the next screen.</p>
        </div>
        <div class="row g-3">
            <?php
            $tiles = [
                ['fa-truck-medical', 'Medical', 'Injury, collapse, ambulance'],
                ['fa-fire', 'Fire', 'Fire, gas leak, explosion'],
                ['fa-shield-halved', 'Crime', 'Robbery, assault, kidnapping'],
                ['fa-car-burst', 'Road accident', 'Crash, casualties, obstruction'],
                ['fa-house-crack', 'Disaster', 'Flood, building collapse'],
                ['fa-bolt', 'Other', 'Electrocution, drowning, unrest'],
            ];
            foreach ($tiles as $t): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="emergency_form.php" class="em-tile">
                        <i class="fa-solid <?php echo $t[0]; ?>"></i>
                        <div class="fw-bold mt-2"><?php echo $t[1]; ?></div>
                        <div class="small text-muted"><?php echo $t[2]; ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==== Preparedness drill ==== -->
<section class="er-section" style="background:#fff;">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-5 text-center">
                <button id="drillBell" class="btn btn-danger rounded-circle drill-bell shadow"><i class="fa-solid fa-bell"></i></button>
                <div class="mt-3">
                    <button id="runDrill" class="btn btn-outline-danger">Run a practice drill</button>
                </div>
                <p class="small text-muted mt-2">Practice mode — nothing is submitted.</p>
            </div>
            <div class="col-lg-7">
                <span class="er-eyebrow">Be prepared</span>
                <h2 class="fw-bold">Emergency drill: know the steps</h2>
                <div class="accordion mt-3" id="drillSteps">
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#d1">1. Stay safe &amp; assess</button></h2>
                        <div id="d1" class="accordion-collapse collapse show" data-bs-parent="#drillSteps"><div class="accordion-body">Move to safety. Quickly check: is anyone injured? Is there fire, a weapon, or ongoing danger?</div></div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#d2">2. Report &amp; pin the location</button></h2>
                        <div id="d2" class="accordion-collapse collapse" data-bs-parent="#drillSteps"><div class="accordion-body">Open a report, choose the emergency type, and drop a pin so responders know exactly where you are.</div></div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#d3">3. Flag injuries or weapons</button></h2>
                        <div id="d3" class="accordion-collapse collapse" data-bs-parent="#drillSteps"><div class="accordion-body">Tick "injuries/casualties" to add an ambulance, or "weapon involved" to alert police — we dispatch every responder needed.</div></div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#d4">4. Stay reachable &amp; track</button></h2>
                        <div id="d4" class="accordion-collapse collapse" data-bs-parent="#drillSteps"><div class="accordion-body">Keep your phone on. Follow live status on your dashboard and add updates until help arrives.</div></div>
                    </div>
                </div>
                <a href="emergency_form.php" class="btn btn-brand mt-3">I'm ready — report now</a>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Practice drill: cycle through the steps with a little shake feedback.
    const bell = document.getElementById('drillBell');
    const run  = document.getElementById('runDrill');
    const steps = ['#d1', '#d2', '#d3', '#d4'];
    function shake(){ bell.classList.add('shake'); setTimeout(()=>bell.classList.remove('shake'), 600); }
    bell && bell.addEventListener('click', shake);
    run && run.addEventListener('click', function () {
        let i = 0;
        (function next(){
            if (i >= steps.length) return;
            const btn = document.querySelector('[data-bs-target="' + steps[i] + '"]');
            if (btn) { new bootstrap.Collapse(document.querySelector(steps[i]), { toggle:true }); shake(); }
            i++; setTimeout(next, 1200);
        })();
    });
</script>

<?php require_once "partials/footer.php"; ?>
