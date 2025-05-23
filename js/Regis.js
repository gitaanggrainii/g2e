function validateForm() {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;
    const terms = document.getElementById("terms").checked;
    const notif = document.getElementById("notif");

    notif.innerText = ""; // reset pesan

    // Validasi email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        notif.innerText = "Email tidak valid.";
        return false;
    }

    // Validasi password
    if (password.length < 6) {
        notif.innerText = "Password minimal 6 karakter.";
        return false;
    }

    // Validasi checkbox
    if (!terms) {
        notif.innerText = "Kamu harus menyetujui syarat & ketentuan.";
        return false;
    }

    return true;
}
            window.onload = () => {
                const params = new URLSearchParams(window.location.search);
                const notif = document.getElementById("notif");
            
                if (params.get("success") === "1") {
                    notif.style.color = "green";
                    notif.innerText = "Registrasi berhasil! Silakan login.";
                } else if (params.get("error")) {
                    notif.style.color = "red";
                    notif.innerText = "Registrasi gagal. Silakan coba lagi.";
                }
            };