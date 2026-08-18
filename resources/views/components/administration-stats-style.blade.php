{{-- Shared summary-card pattern, based on Administrasi Surat. --}}
<style>
.admin-stats { display:grid !important; grid-template-columns:repeat(5,minmax(0,1fr)) !important; gap:12px !important; margin-bottom:20px !important; }
.admin-stats.admin-stats--four { grid-template-columns:repeat(4,minmax(0,1fr)) !important; }
.admin-stats .stat-card, .admin-stats .stat-pill, .admin-stats .stat-card-custom { min-height:0; padding:16px !important; background:#fff !important; border:0 !important; border-radius:14px !important; box-shadow:0 2px 10px rgba(0,0,0,.05) !important; color:inherit; text-align:center !important; display:block !important; text-decoration:none; transition:transform .15s, box-shadow .15s; }
.admin-stats .stat-card:hover, .admin-stats .stat-pill:hover, .admin-stats .stat-card-custom:hover { transform:translateY(-2px); box-shadow:0 5px 18px rgba(0,0,0,.1) !important; }
.admin-stats .stat-icon { width:42px !important; height:42px !important; margin:0 auto 10px !important; border-radius:12px !important; display:flex !important; align-items:center; justify-content:center; color:#fff; font-size:17px !important; }
.admin-stats .stat-count, .admin-stats .stat-num, .admin-stats .sp-count, .admin-stats .num, .admin-stats .count { font-size:24px !important; font-weight:800 !important; line-height:1 !important; color:#333 !important; margin:0 !important; }
.admin-stats .stat-label, .admin-stats .sp-label, .admin-stats .lbl, .admin-stats .label { margin-top:4px !important; font-size:11px !important; font-weight:600 !important; line-height:1.35; color:#999 !important; text-transform:none !important; letter-spacing:0 !important; }
.admin-stats .sub { margin-top:2px; font-size:10px; color:#aab; }
.admin-stats .sp-dot { display:none !important; }
.admin-stats .active, .admin-stats .active-tab { box-shadow:inset 0 0 0 2px #667eea,0 2px 10px rgba(0,0,0,.05) !important; }
@media (max-width:1100px) { .admin-stats { grid-template-columns:repeat(3,minmax(0,1fr)) !important; } .admin-stats.admin-stats--four { grid-template-columns:repeat(2,minmax(0,1fr)) !important; } }
@media (max-width:640px) { .admin-stats, .admin-stats.admin-stats--four { grid-template-columns:repeat(2,minmax(0,1fr)) !important; } }
</style>
