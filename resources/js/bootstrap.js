import axios from "axios";
import swal from "sweetalert2";

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.swal = swal;
window.toast = swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    customClass: {
        container: "custom-class-toast",
    },
});

window.addEventListener('toast', e => {
    window.toast.fire({ icon: e.detail.type ?? 'success', title: e.detail.message });
});