/**
 * common.js — Redis Solution CRM
 * Global UI utilities: delete confirmation, toasts, file preview, password tools.
 * Uses: window.axios (from bootstrap.js), window.swal (SweetAlert2), Alpine.js
 * No jQuery. No DataTables.
 */

// ─── Delete Confirmation ─────────────────────────────────────────────────────
// Usage (standard controller delete):
//   <button data-delete-url="/admin/projects/1" onclick="deleteRecord(this)">Delete</button>
//
// Usage (Livewire component delete):
//   <button data-id="1" onclick="deleteWire(this, $wire)">Delete</button>

function deleteRecord(btn) {
    const url = btn.getAttribute('data-delete-url');

    window.swal.fire({
        title: 'Delete this record?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#FF6400',
        cancelButtonColor: 'rgba(255,255,255,0.1)',
        background: '#1A1829',
        color: '#fff',
    }).then(result => {
        if (! result.isConfirmed) return;

        window.swal.fire({
            title: 'Deleting…',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            background: '#1A1829',
            color: '#fff',
            didOpen: () => window.swal.showLoading(),
        });

        window.axios.delete(url)
            .then(res => {
                window.swal.close();
                window.toast.fire({ icon: 'success', title: res.data.message ?? 'Deleted successfully' });

                if (res.data.redirect) {
                    window.location.href = res.data.redirect;
                } else {
                    // Remove the table row (the closest <tr> ancestor)
                    const row = btn.closest('tr');
                    if (row) row.remove();
                }
            })
            .catch(err => {
                window.swal.close();
                window.toast.fire({ icon: 'error', title: err.response?.data?.message ?? 'Delete failed' });
            });
    });
}

function deleteWire(btn, wire) {
    const id = btn.getAttribute('data-id');

    window.swal.fire({
        title: 'Delete this record?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#FF6400',
        cancelButtonColor: 'rgba(255,255,255,0.1)',
        background: '#1A1829',
        color: '#fff',
    }).then(result => {
        if (result.isConfirmed) {
            wire.dispatch('delete', { id: parseInt(id) });
        }
    });
}

// ─── Status Toggle ───────────────────────────────────────────────────────────
// Usage: <button data-url="/admin/users/1/toggle-status" onclick="toggleStatus(this)">

function toggleStatus(btn) {
    const url = btn.getAttribute('data-url');
    const text = btn.getAttribute('data-confirm-text') ?? 'Change status?';

    window.swal.fire({
        title: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#FF6400',
        background: '#1A1829',
        color: '#fff',
    }).then(result => {
        if (! result.isConfirmed) return;

        window.axios.post(url)
            .then(res => {
                window.toast.fire({ icon: 'success', title: res.data.message ?? 'Status updated' });
                // Reload Livewire component on the page (if any)
                if (window.Livewire) window.Livewire.dispatch('refresh');
            })
            .catch(err => {
                window.toast.fire({ icon: 'error', title: err.response?.data?.message ?? 'Failed' });
            });
    });
}

// ─── Toast shortcut ─────────────────────────────────────────────────────────
function toastMessage(message = '', type = 'error') {
    if (! message) message = type === 'error' ? 'Something went wrong' : 'Done';
    window.toast.fire({ icon: type, title: message });
}

// ─── File preview on input change ────────────────────────────────────────────
// Usage: <input type="file" onchange="previewImage(this, 'preview-img-id')">

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (! preview || ! input.files || ! input.files[0]) return;

    const reader = new FileReader();
    reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
    reader.readAsDataURL(input.files[0]);
}

// ─── Password Generate / Copy ────────────────────────────────────────────────
function generatePassword(fieldId = 'password', confirmFieldId = 'password_confirmation') {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$';
    const password = Array.from({ length: 12 }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
    const field = document.getElementById(fieldId);
    const confirm = document.getElementById(confirmFieldId);
    if (field) field.value = password;
    if (confirm) confirm.value = password;
}

function copyToClipboard(fieldId = 'password') {
    const field = document.getElementById(fieldId);
    if (! field) return;
    field.select();
    navigator.clipboard.writeText(field.value).then(() => {
        toastMessage('Copied to clipboard', 'success');
    });
}

// ─── Vault Reveal Timer ──────────────────────────────────────────────────────
// Alpine.js component — used in credentials/api-keys reveal UI
// Register: Alpine.data('vaultReveal', vaultReveal)

function vaultReveal(revealUrl) {
    return {
        revealed: false,
        value: '',
        timer: 30,
        interval: null,

        async reveal() {
            try {
                const res = await window.axios.post(revealUrl);
                this.value = res.data.value;
                this.revealed = true;
                this.timer = 30;
                this.interval = setInterval(() => {
                    this.timer--;
                    if (this.timer <= 0) {
                        this.hide();
                    }
                }, 1000);
            } catch (err) {
                toastMessage(err.response?.data?.message ?? 'Cannot reveal', 'error');
            }
        },

        hide() {
            this.revealed = false;
            this.value = '';
            if (this.interval) { clearInterval(this.interval); this.interval = null; }
        },

        copy() {
            navigator.clipboard.writeText(this.value).then(() => {
                toastMessage('Copied to clipboard', 'success');
            });
        },
    };
}

// Register with Alpine when it's ready
document.addEventListener('alpine:init', () => {
    Alpine.data('vaultReveal', vaultReveal);
});
