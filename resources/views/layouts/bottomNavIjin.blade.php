<!-- App Bottom Menu -->
<a href="{{ route('tambah.ijin') }}" class="appBottomMenu" style="background-color: transparent; border:0cm">
    {{-- <div class="appBottomMenu" style="background-color: transparent; border:0cm"> --}}
    <div class="fab-container">
        <div class="action-button large" id="fabButton">
            <ion-icon name="add" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </div>
    </div>
    {{-- </div> --}}
</a>
<!-- * App Bottom Menu -->

<style>
    .appBottomMenu {
        position: fixed;
        bottom: 0;
        right: 0;
        width: auto;
        height: auto;
        z-index: 999;
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
        z-index: 1000;
        transition: transform 0.3s ease, background-color 0.3s ease;
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
    }

    .fab-item {
        display: flex;
        align-items: center;
        background: white;
        padding: 8px 15px;
        border-radius: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: #333;
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .fab-item:nth-child(1) {
        transition-delay: 0.05s;
    }

    .fab-item:nth-child(2) {
        transition-delay: 0.1s;
    }

    .fab-item:nth-child(3) {
        transition-delay: 0.15s;
    }

    .fab-item span {
        margin-left: 8px;
    }

    .fab-item:hover {
        background: #f0f0f0;
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

    /* Animated rotation for the plus icon */
    .fab-menu.active+.action-button ion-icon[name="add"],
    #fabButton.rotating ion-icon {
        transform: rotate(135deg);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fabButton = document.getElementById('fabButton');
        const fabMenu = document.getElementById('fabMenu');

        fabButton.addEventListener('click', function() {
            fabMenu.classList.toggle('active');
            fabButton.classList.toggle('rotating');

            // Ubah ikon ketika menu terbuka/tertutup
            const icon = fabButton.querySelector('ion-icon');
            if (fabMenu.classList.contains('active')) {
                setTimeout(() => {
                    icon.setAttribute('name', 'close');
                }, 150);
            } else {
                setTimeout(() => {
                    icon.setAttribute('name', 'add');
                }, 150);
            }
        });

        // Tutup menu ketika klik di luar tombol
        document.addEventListener('click', function(e) {
            if (!fabButton.contains(e.target) && !fabMenu.contains(e.target)) {
                fabMenu.classList.remove('active');
                fabButton.classList.remove('rotating');
                setTimeout(() => {
                    fabButton.querySelector('ion-icon').setAttribute('name', 'add');
                }, 150);
            }
        });

        // Tambahkan efek ripple ketika tombol diklik
        fabButton.addEventListener('mousedown', function(e) {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);

            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${e.clientX - rect.left - size/2}px`;
            ripple.style.top = `${e.clientY - rect.top - size/2}px`;

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
</script>

<style>
    /* Tambahkan efek ripple */
    .action-button {
        position: relative;
        overflow: hidden;
    }

    .ripple {
        position: absolute;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>
