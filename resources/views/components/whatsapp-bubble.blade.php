@php $number = setting('whatsapp_number', ''); $message = setting('whatsapp_default_message', 'Hello! I am interested in your services.'); @endphp

@if($number)
<div
    x-data="{ open: false }"
    style="position:fixed;bottom:1.5rem;right:1.5rem;z-index:200;font-family:'DM Sans',sans-serif"
    aria-label="Chat on WhatsApp"
>
    {{-- Expandable chat box --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        style="display:none;position:absolute;bottom:calc(100% + 1rem);right:0;width:280px;background:#1A1829;border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:1.25rem;box-shadow:0 20px 40px rgba(0,0,0,0.4)"
    >
        <p style="font-size:0.9rem;color:rgba(255,255,255,0.8);margin-bottom:1rem;line-height:1.5">
            Hi there! 👋 Chat with us on WhatsApp for quick support.
        </p>
        <a
            href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $number) }}?text={{ urlencode($message) }}"
            target="_blank"
            rel="noopener"
            style="display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.65rem 1.25rem;background:#25D366;color:#fff;border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;transition:background 0.2s"
            onmouseover="this.style.background='#1EBE5D'"
            onmouseout="this.style.background='#25D366'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.109.549 4.09 1.509 5.815L0 24l6.335-1.493C8.013 23.464 9.97 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.9 0-3.703-.516-5.263-1.414l-.374-.225-3.882.915.978-3.761-.246-.387A9.934 9.934 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
            Chat on WhatsApp
        </a>
    </div>

    {{-- Floating button --}}
    <button
        @click="open = !open"
        style="width:56px;height:56px;border-radius:50%;background:#25D366;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:transform 0.2s,box-shadow 0.2s"
        onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 6px 28px rgba(37,211,102,0.5)'"
        onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 20px rgba(37,211,102,0.4)'"
        aria-label="Open WhatsApp chat"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" style="width:28px;height:28px"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.109.549 4.09 1.509 5.815L0 24l6.335-1.493C8.013 23.464 9.97 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.9 0-3.703-.516-5.263-1.414l-.374-.225-3.882.915.978-3.761-.246-.387A9.934 9.934 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
    </button>
</div>
@endif
