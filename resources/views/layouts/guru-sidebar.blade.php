<nav id="sidebar" class="sidebar" style="zoom:90%">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('guru.dashboard') }}">
            <i class="align-middle" data-feather="home"></i>
            <span class="align-middle">{{ Auth::guard('guru')->user()->nama_guru ?? 'Guru' }}</span>
        </a>

        <ul class="sidebar-nav">
            <!-- Dashboard -->
            <li class="sidebar-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('guru.dashboard') }}">
                    <i class="align-middle" data-feather="home"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <!-- Data Master -->
            <li class="sidebar-item">
                <a class="sidebar-link menu-link" data-menu="data-master" href="#">
                    <i class="align-middle" data-feather="database"></i>
                    <span class="align-middle">Data Master</span>
                </a>
            </li>

            <!-- Pendidikan -->
            <li class="sidebar-item">
                <a class="sidebar-link menu-link" data-menu="pendidikan" href="#">
                    <i class="align-middle" data-feather="book-open"></i>
                    <span class="align-middle">Pendidikan</span>
                </a>
            </li>

            <!-- Laporan -->
            <li class="sidebar-item">
                <a class="sidebar-link menu-link" data-menu="laporan" href="#">
                    <i class="align-middle" data-feather="bar-chart-2"></i>
                    <span class="align-middle">Laporan</span>
                </a>
            </li>

            <!-- Pengaturan -->
            <li class="sidebar-item">
                <a class="sidebar-link menu-link" data-menu="pengaturan" href="#">
                    <i class="align-middle" data-feather="settings"></i>
                    <span class="align-middle">Pengaturan</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="sidebar-item">
                <a class="sidebar-link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="align-middle" data-feather="log-out"></i>
                    <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const menuLinks = document.querySelectorAll('.menu-link');
                const contentArea = document.querySelector('.content');

                menuLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Remove active class from all menu items
                        menuLinks.forEach(l => l.closest('.sidebar-item').classList.remove('active'));
                        // Add active class to clicked menu item
                        this.closest('.sidebar-item').classList.add('active');

                        const menu = this.getAttribute('data-menu');

                        // Load content via AJAX
                        fetch(`/guru/menu/${menu}`)
                            .then(response => response.text())
                            .then(html => {
                                if (contentArea) {
                                    contentArea.innerHTML = html;
                                }
                            })
                            .catch(error => console.error('Error loading content:', error));
                    });
                });
            });
        </script>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
