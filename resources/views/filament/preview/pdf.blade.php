<div style="display:flex; flex-direction:column; gap:14px; min-width:min(78vw, 960px);">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; border:1px solid #e5e7eb; border-radius:16px; padding:12px 14px; background:linear-gradient(135deg, #f8fafc, #eef2ff);">
        <div>
            <div style="font-size:13px; font-weight:700; color:#0f172a;">Document preview</div>
            <div style="font-size:12px; color:#475569;">Review the ordinance PDF directly in the modal or open it in a separate tab.</div>
        </div>

        <a
            href="{{ $url }}"
            target="_blank"
            rel="noopener noreferrer"
            style="display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:12px; background:#0f172a; color:#f8fafc; font-size:12px; font-weight:700; text-decoration:none; white-space:nowrap;"
        >
            Open in new tab
        </a>
    </div>

    <div style="overflow:hidden; border:1px solid #dbeafe; border-radius:18px; background:#0f172a; box-shadow:0 18px 48px rgba(15, 23, 42, 0.18);">
        <iframe
            src="{{ $url }}"
            width="100%"
            height="640"
            style="display:block; border:0; background:white;"
            title="PDF preview"
        ></iframe>
    </div>
</div>
