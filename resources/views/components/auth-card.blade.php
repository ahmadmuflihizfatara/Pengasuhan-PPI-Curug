@props(['title', 'subtitle' => null, 'width' => '440px'])

<div style="width:100%;max-width:{{ $width }}">
    <div style="display:flex;justify-content:center;margin-bottom:var(--space-6)">
        <div class="ds-brand" style="background:rgba(255,255,255,.18);border-color:rgba(255,255,255,.3);padding:var(--space-3) var(--space-6) var(--space-3) var(--space-4);gap:var(--space-4);color:var(--ink-on-dark)">
            <img src="{{ asset('assets/img/logo-ppi.png') }}" alt="Logo PPI Curug" style="height:44px;width:auto;filter:drop-shadow(0 2px 6px rgba(0,0,0,.35))">
            <span>
                <span class="ds-brand__name" style="display:block;font-size:15px;letter-spacing:0;margin-bottom:4px">PPI Curug</span>
                <span class="ds-brand__sub" style="font-size:11px;letter-spacing:.08em;color:#7dd3fc">Pengasuhan Taruna</span>
            </span>
        </div>
    </div>

    <div class="ds-workspace" style="background:var(--glass-card)">
        <div style="text-align:center;margin-bottom:var(--space-6)">
            <h1 style="margin:0 0 var(--space-1);font-size:22px;line-height:30px;font-weight:800;letter-spacing:-.02em;color:var(--ink-900)">{{ $title }}</h1>
            @if ($subtitle)
                <p style="margin:0;font-size:12px;line-height:18px;color:var(--ink-700)">{{ $subtitle }}</p>
            @endif
        </div>

        {{ $slot }}
    </div>
</div>
