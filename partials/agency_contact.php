<?php
/**
 * Renders a "responsible agency" contact card for a response-unit page, so a
 * report in any state always shows someone to call. Call
 * render_agency_contact($agency) inside the page body.
 */
if (!function_exists('render_agency_contact')) {
    function render_agency_contact($agency)
    {
        $name  = $agency['agency_name']  ?? null;
        $phone = $agency['agency_phone'] ?? null;
        $state = $agency['state_name']   ?? null;
        echo '<div class="row justify-content-center mb-4"><div class="col-md-10">';
        echo '<div class="card border-danger shadow-sm"><div class="card-body d-flex flex-wrap justify-content-between align-items-center">';
        echo '<div><div class="fw-bold">' . htmlspecialchars($name ?: 'National Emergency Line') . '</div>';
        echo '<div class="text-muted small">Responsible agency'
            . ($state ? ' &middot; ' . htmlspecialchars($state) : '') . '</div></div>';
        echo '<div class="text-end">';
        if ($phone) {
            echo '<a class="btn btn-danger" href="tel:' . htmlspecialchars($phone) . '">'
                . '<i class="fas fa-phone"></i> Call ' . htmlspecialchars($phone) . '</a>';
        }
        echo '<a class="btn btn-outline-danger ms-2" href="tel:112">Call 112</a>';
        echo '</div></div></div></div></div>';
    }
}
