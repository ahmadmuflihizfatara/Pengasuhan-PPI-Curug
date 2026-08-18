{{-- Shared list pattern: mirrors Administrasi Surat without changing page data or permissions. --}}
<style>
.admin-list-filter { background:#fff !important; border-radius:14px !important; padding:16px 20px !important; box-shadow:0 2px 10px rgba(0,0,0,.05) !important; margin-bottom:18px !important; }
.admin-list-filter form, .admin-list-filter .admin-filter-fields { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.admin-list-filter .search-wrap, .admin-list-filter .filter-search, .admin-list-filter .search-bar { position:relative; flex:1 1 260px; min-width:200px; margin:0; }
.admin-list-filter .search-wrap i, .admin-list-filter .filter-search .fa-search { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#bbb; font-size:12px; pointer-events:none; }
.admin-list-filter .search-input, .admin-list-filter .filter-input, .admin-list-filter .search-bar input, .admin-list-filter .form-control { width:100%; height:42px; padding:9px 12px 9px 34px; border:1.5px solid #d4dbe5 !important; border-radius:10px !important; outline:0; color:#444; background:#f9fafb !important; font:13px 'Inter',sans-serif; box-shadow:none !important; }
.admin-list-filter .filter-select, .admin-list-filter .form-select { height:42px; padding:9px 14px; border:1.5px solid #d4dbe5 !important; border-radius:10px !important; outline:0; color:#444; background:#f9fafb !important; font:13px 'Inter',sans-serif; cursor:pointer; box-shadow:none !important; }
.admin-list-filter .search-input:focus, .admin-list-filter .filter-input:focus, .admin-list-filter .search-bar input:focus, .admin-list-filter .filter-select:focus, .admin-list-filter .form-control:focus, .admin-list-filter .form-select:focus { border-color:#12283a; box-shadow:none; }
.admin-list-filter .btn-filter { height:38px; border:0 !important; border-radius:10px !important; padding:9px 20px; background:linear-gradient(135deg,#12283a,#12283a) !important; color:#fff !important; font:700 13px 'Inter',sans-serif; display:inline-flex; align-items:center; gap:6px; cursor:pointer; white-space:nowrap; }
.admin-list-filter .btn-reset { color:#999; font:600 13px 'Inter',sans-serif; text-decoration:none; display:inline-flex; gap:5px; align-items:center; white-space:nowrap; }
.admin-list-filter .filter-label { display:none; }
.admin-list-filter .admin-log-filter-form { display:grid; grid-template-columns:minmax(180px,1.7fr) minmax(130px,.9fr) minmax(130px,.9fr) minmax(150px,1.1fr) auto; gap:10px; align-items:center; width:100%; max-width:100%; }
.admin-list-filter .admin-log-filter-form > div { min-width:0; }
.admin-list-filter .admin-log-actions { display:flex; align-items:center; gap:8px; white-space:nowrap; }
.admin-list-table { background:transparent !important; border-radius:16px !important; padding:0 !important; overflow-x:auto !important; box-shadow:none !important; }
.admin-list-table .table-responsive { border-radius:16px; overflow-x:auto; }
.admin-list-table .tab-content { padding:0 !important; }
.admin-list-table table { width:100%; min-width:720px; border-collapse:separate; border-spacing:0; margin:0; border-radius:16px; overflow:hidden; box-shadow:0 2px 16px rgba(0,0,0,.06); }
.admin-list-table thead tr { background:linear-gradient(135deg,#12283a,#12283a) !important; }
.admin-list-table th { padding:13px 14px !important; border:0 !important; text-align:left; color:#fff !important; font:700 10px 'Inter',sans-serif; letter-spacing:.06em; white-space:nowrap; }
.admin-list-table thead th:first-child { border-top-left-radius:16px; }
.admin-list-table thead th:last-child { border-top-right-radius:16px; }
.admin-list-table td { padding:12px 14px !important; border-top:1px solid #f0f2f7 !important; vertical-align:middle; color:#444; background:#fff; font:13px 'Inter',sans-serif; }
.admin-list-table tbody tr { transition:background .1s; }
.admin-list-table tbody tr:hover td { background:#f5f7fa; }
.admin-list-table tbody tr:last-child td:first-child { border-bottom-left-radius:16px; }
.admin-list-table tbody tr:last-child td:last-child { border-bottom-right-radius:16px; }
.admin-list-table .empty-state, .admin-list-table .empty { background:#fff; border-radius:16px; }
.admin-list-table .table-actions { display:flex; align-items:center; justify-content:center; gap:5px; white-space:nowrap; }
.admin-list-table .btn-view, .admin-list-table .btn-edit, .admin-list-table .btn-delete, .admin-list-table .btn-approve-ico, .admin-list-table .btn-reject-ico { min-width:30px; min-height:28px; padding:5px 9px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; }
.admin-list-table .btn-view { background:#e0f7ff; color:#0d9488; }
.admin-list-table .btn-edit { background:rgba(18,40,58,0.06); color:#12283a; }
.admin-list-table .btn-delete { background:#fff0f0; color:#e53e3e; }
.admin-list-table .btn-approve-ico { background:#e6fff5; color:#38a169; }
.admin-list-table .btn-reject-ico { background:#fff5f5; color:#e53e3e; }
@media (max-width:780px) { .admin-list-filter .admin-log-filter-form { grid-template-columns:repeat(2,minmax(0,1fr)); } .admin-list-filter .admin-log-actions { grid-column:1 / -1; } }
@media (max-width:768px) { .admin-list-filter { padding:12px; } .admin-list-filter .search-wrap, .admin-list-filter .filter-search, .admin-list-filter .search-bar { flex-basis:100%; } .admin-list-filter .filter-select { flex:1 1 140px; } .admin-list-filter .btn-filter { flex:1; justify-content:center; } .admin-list-filter .admin-log-filter-form { grid-template-columns:1fr; } .admin-list-filter .admin-log-actions { grid-column:auto; } }
</style>
