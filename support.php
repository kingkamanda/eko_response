<?php
session_start();
require_once "user_guard.php";
require_once "classes/User.php";

$user = (new User())->get_current_user($_SESSION['useronline']);
$firstname = ucfirst($user['user_fullname'] ?? 'there');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Chat - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/static/css/app.css">
    <style>
        #chatWindow { height: 55vh; overflow-y: auto; background:#f8fafc; border-radius:.5rem; padding:1rem; }
        .msg { max-width: 75%; padding:.5rem .8rem; border-radius:1rem; margin-bottom:.5rem; }
        .msg.user    { background: var(--er-primary); color:#fff; margin-left:auto; border-bottom-right-radius:.25rem; }
        .msg.support { background:#e5e7eb; color:#111; margin-right:auto; border-bottom-left-radius:.25rem; }
        .msg small { display:block; opacity:.7; font-size:.7rem; margin-top:.15rem; }
    </style>
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="mb-0"><i class="fa-solid fa-headset text-danger"></i> Support Chat</h3>
                    <a href="user_dashboard.php" class="btn btn-outline-secondary btn-sm">← Dashboard</a>
                </div>
                <p class="text-muted">Hi <?php echo htmlspecialchars($firstname); ?>, how can we help? Our team replies here — this window updates automatically.</p>

                <div class="card er-card">
                    <div class="card-body">
                        <div id="chatWindow"></div>
                        <form id="chatForm" class="d-flex gap-2 mt-3">
                            <input type="text" id="chatInput" class="form-control" placeholder="Type a message…" autocomplete="off" maxlength="1000" required>
                            <button class="btn btn-brand"><i class="fa-solid fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const win = document.getElementById('chatWindow');
        const form = document.getElementById('chatForm');
        const input = document.getElementById('chatInput');
        let lastId = 0;

        function esc(s){ const d=document.createElement('div'); d.textContent=s; return d.innerHTML; }

        function render(messages) {
            messages.forEach(function (m) {
                const div = document.createElement('div');
                div.className = 'msg ' + (m.sender === 'support' ? 'support' : 'user');
                div.innerHTML = esc(m.body) + '<small>' + esc(m.created_at) + '</small>';
                win.appendChild(div);
                lastId = Math.max(lastId, parseInt(m.message_id, 10));
            });
            if (messages.length) win.scrollTop = win.scrollHeight;
        }

        function poll() {
            fetch('support_api.php?since=' + lastId)
                .then(r => r.json())
                .then(d => { if (d.messages) render(d.messages); })
                .catch(() => {});
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const body = input.value.trim();
            if (!body) return;
            input.value = '';
            const fd = new FormData();
            fd.append('body', body);
            fetch('support_api.php?since=' + lastId, { method: 'POST', body: fd })
                .then(r => r.json())
                .then(d => { if (d.messages) render(d.messages); })
                .catch(() => {});
        });

        poll();
        setInterval(poll, 3000);   // near-live via polling
    </script>
</body>
</html>
