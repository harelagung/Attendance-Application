<!-- App Bottom Menu -->
<div id="overlay"></div>
<div class="appBottomMenu" style="background-color: transparent; border:0ch">
    <div class="fab-container">
        <div class="action-button large" id="fabButton">
            <ion-icon name="settings" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </div>

        <!-- Pop-up Menu -->
        <div id="fabMenu" class="fab-menu">
            @if (auth()->user()->jabatan == 'Admin')
                <a href="{{ route('dashboard.dashboardadmin') }}" class="fab-item">
                    <ion-icon name="person" role="img" class="md hydrated" aria-label="document"></ion-icon>
                    <span>Administrator</span>
                </a>
            @endif
            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <a href="#" onclick="this.closest('form').submit();return false;" class="fab-item">
                    <ion-icon name="log-out" role="img" class="md hydrated" aria-label="power"></ion-icon>
                    <span>Keluar</span>
                </a>
            </form>
        </div>
    </div>
</div>
<!-- * App Bottom Menu -->

<style>
    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100vw;
        /* Change to viewport width */
        height: 100vh;
        /* Change to viewport height */
        background: rgba(0, 0, 0, 0.315);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        opacity: 0;
        visibility: hidden;
        transition: opacity .3s ease;
        z-index: 9996;
        pointer-events: none;
        will-change: opacity;
    }

    /* ketika aktif → tampil */
    #overlay.active {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    .appBottomMenu {
        position: fixed;
        bottom: 0;
        right: 0;
        width: auto;
        height: auto;
        z-index: 9999;
        display: flex;
        align-items: flex-end;
        justify-content: flex-end;
        padding: 20px;
    }

    .fab-container {
        position: relative;
    }

    .action-button {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #007bff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        cursor: pointer;
        z-index: 10000;
        transition: transform 0.3s ease, background-color 0.3s ease;
        position: relative;
    }

    .action-button:active {
        transform: scale(0.95);
    }

    .action-button ion-icon {
        font-size: 24px;
        transition: transform 0.3s ease;
    }

    .fab-menu {
        position: absolute;
        bottom: 70px;
        right: 0;
        background: transparent;
        opacity: 0;
        visibility: hidden;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 15px;
        transform: translateY(20px);
        transition: all 0.3s ease;
        z-index: 10000;
    }

    .fab-item {
        display: flex;
        align-items: center;
        background: #007bff;
        padding: 8px 12px;
        border-radius: 20px;
        text-decoration: none;
        color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transform: translateY(10px);
        opacity: 0;
        transition: all .3s ease;
        z-index: 10001;
    }

    .fab-item:nth-child(1) {
        transition-delay: 0.05s;
    }

    .fab-item:nth-child(2) {
        transition-delay: 0.1s;
    }

    .fab-item span {
        margin-left: 8px;
    }

    .fab-item:hover {
        background: #ffffff;
        transform: translateX(-5px);
    }

    .fab-menu.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .fab-menu.active .fab-item {
        transform: translateY(0);
        opacity: 1;
    }

    #fabButton.rotating ion-icon {
        transform: rotate(360deg);
    }

    /* Ripple effect */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        transform: scale(0);
        animation: ripple .6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fabButton = document.getElementById('fabButton');
        const fabMenu = document.getElementById('fabMenu');
        const overlay = document.getElementById('overlay');

        // Memastikan overlay ditambahkan ke body langsung
        if (!document.body.contains(overlay)) {
            document.body.appendChild(overlay);
        }

        // 1. Klik tombol → toggle menu & rotasi icon
        fabButton.addEventListener('click', function(e) {
            e.stopPropagation(); // supaya klik tidak bubble ke document
            fabMenu.classList.toggle('active'); // show/hide popup menu
            fabButton.classList.toggle('rotating'); // tambahkan/hapus class rotasi
            overlay.classList.toggle('active'); // tampilkan / sembunyikan blur

            // Tambahkan class ke body untuk mencegah scroll
            if (overlay.classList.contains('active')) {
                document.body.style.overflow = 'hidden';

                // Force repaint untuk memastikan backdrop-filter bekerja
                void overlay.offsetHeight;
            } else {
                document.body.style.overflow = '';
            }
        });

        // 2. Klik di overlay → tutup menu
        overlay.addEventListener('click', closeMenu);

        // 3. Klik di luar tombol/menu → tutup semuanya
        document.addEventListener('click', function(e) {
            if (!fabButton.contains(e.target) && !fabMenu.contains(e.target)) {
                closeMenu();
            }
        });

        function closeMenu() {
            fabMenu.classList.remove('active');
            fabButton.classList.remove('rotating');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // 4. Ripple effect saat tekan tombol
        fabButton.addEventListener('mousedown', function(e) {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';

            setTimeout(() => ripple.remove(), 600);
        });
    });
</script>
