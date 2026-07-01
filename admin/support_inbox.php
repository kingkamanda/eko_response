<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();
$conversations = $admin->support_conversations();
$pendingCount  = $admin->count_pending_categories();
$openUser = filter_input(INPUT_GET, 'user', FILTER_VALIDATE_INT);
$pageTitle = 'Support Inbox - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?>
<style>
    #adminChat { height: 55vh; overflow-y:auto; background:#f8fafc; border-radius:.5rem; padding:1rem; }
    .msg { max-width:75%; padding:.5rem .8rem; border-radius:1rem; margin-bottom:.5rem; }
    .msg.support { background:#0d6efd; color:#fff; margin-left:auto; border-bottom-right-radius:.25rem; }
    .msg.user    { background:#e5e7eb; color:#111; margin-right:auto; border-bottom-left-radius:.25rem; }
    .msg small { display:block; opacity:.7; font-size:.7rem; }
    .conv-item.active { background:#eef2ff; }
</style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'support'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-3">Support Inbox</h3>
            <div class="row g-3">
                <!-- Conversation list -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header"><h6 class="mb-0">Conversations</h6></div>
                        <div class="list-group list-group-flush">
                            <?php if (empty($conversations)): ?>
                                <div class="list-group-item text-muted">No messages yet.</div>
                            <?php else: foreach ($conversations as $c): ?>
                                <a href="support_inbox.php?user=<?php echo (int)$c['user_id']; ?>"
                                   class="list-group-item list-group-item-action conv-item <?php echo ($openUser === (int)$c['user_id']) ? 'active' : ''; ?>">
                                    <div class="d-flex justify-content-between">
                                        <strong><?php echo htmlspecialchars($c['user_fullname'] ?? ('User #' . $c['user_id'])); ?></strong>
                                        <?php if ((int)$c['unread'] > 0): ?><span class="badge bg-danger rounded-pill"><?php echo (int)$c['unread']; ?></span><?php endif; ?>
                                    </div>
                                    <div class="small text-muted text-truncate"><?php echo htmlspecialchars($c['last_message'] ?? ''); ?></div>
                                    <div class="small text-muted"><?php echo htmlspecialchars($c['last_time'] ?? ''); ?></div>
                                </a>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Conversation view -->
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <?php if (!$openUser): ?>
                                <p class="text-muted mb-0">Select a conversation to view and reply.</p>
                            <?php else: ?>
                                <div id="adminChat"></div>
                                <form id="replyForm" class="d-flex gap-2 mt-3">
                                    <input type="hidden" id="convUser" value="<?php echo (int)$openUser; ?>">
                                    <input type="text" id="replyInput" class="form-control" placeholder="Type a reply…" autocomplete="off" maxlength="1000" required>
                                    <button class="btn btn-primary">Send</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="./assets/static/bootstrap/js/bootstrap.bundle.min.js"></script>
<?php if ($openUser): ?>
<script>
    const chat = document.getElementById('adminChat');
    const form = document.getElementById('replyForm');
    const input = document.getElementById('replyInput');
    const userId = document.getElementById('convUser').value;
    let lastId = 0;

    function esc(s){ const d=document.createElement('div'); d.textContent=s; return d.innerHTML; }
    function render(messages) {
        messages.forEach(function (m) {
            const div = document.createElement('div');
            div.className = 'msg ' + (m.sender === 'support' ? 'support' : 'user');
            div.innerHTML = esc(m.body) + '<small>' + esc(m.created_at) + '</small>';
            chat.appendChild(div);
            lastId = Math.max(lastId, parseInt(m.message_id, 10));
        });
        if (messages.length) chat.scrollTop = chat.scrollHeight;
    }
    function poll() {
        fetch('support_api.php?user=' + userId + '&since=' + lastId)
            .then(r => r.json()).then(d => { if (d.messages) render(d.messages); }).catch(()=>{});
    }
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const body = input.value.trim(); if (!body) return;
        input.value = '';
        const fd = new FormData(); fd.append('user_id', userId); fd.append('body', body);
        fetch('support_api.php?user=' + userId + '&since=' + lastId, { method:'POST', body: fd })
            .then(r => r.json()).then(d => { if (d.messages) render(d.messages); }).catch(()=>{});
    });
    poll();
    setInterval(poll, 3000);
</script>
<?php endif; ?>
</body>
</html>
