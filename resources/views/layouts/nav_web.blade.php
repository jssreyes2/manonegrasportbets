<nav class="sidebar">
    <div class="sidebar-header">
        <button class="sidebar-toggle" id="sidebar-toggle-btn">
            <img src="{{asset('Imagenes/iconos/arrow-left.svg')}}" alt="Toggle Sidebar">
        </button>
    </div>

    <div class="sidebar-menu">
        <a href="dashboard.html" class="sidebar-link active">
            <img src="{{asset('Imagenes/iconos/dashboard-icon.svg')}}" alt="">
            <span>Dashboard</span>
        </a>
        <a href="#" class="sidebar-link">
            <img src="{{asset('Imagenes/iconos/pedidos-icon.svg')}}" alt="">
            <span>Mis Pedidos</span>
        </a>
        <a href="#" class="sidebar-link">
            <img src="{{asset('Imagenes/iconos/chats-icon.svg')}}" alt="">
            <span>Chats</span>
        </a>
        <a href="#" class="sidebar-link">
            <img src="{{asset('Imagenes/iconos/services-icon.svg')}}" alt="">
            <span>Servicios</span>
        </a>
        <a href="#" class="sidebar-link">
            <img src="{{asset('Imagenes/iconos/customers-icon.svg')}}" alt="">
            <span>Clientes</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <img src="{{asset('Imagenes/Profile-Pictures/zombie-kawaii.jpg')}}" alt="User Avatar" class="user-avatar">
            <div class="user-details">
                <span class="user-name" id="sidebar-user-name">Inicia Sesión</span>
                <span class="user-email" id="sidebar-user-email">accede a tu cuenta</span>
            </div>
            <button class="settings-arrow-btn" id="open-settings-btn">
                <img src="{{asset('Imagenes/iconos/arrow-left.svg')}}" alt="Abrir ajustes">
            </button>
        </div>
    </div>
</nav>

<nav class="settings-sidebar" id="settings-sidebar">
    <div class="settings-sidebar-header">
        <h3>Ajustes de Cuenta</h3>
        <button class="settings-close-btn" id="close-settings-btn">&times;</button>
    </div>
    <div class="settings-sidebar-menu">
        <a href="profile.html" class="settings-link"> <img src="{{asset('Imagenes/iconos/user-icon.svg')}}" alt="Mi Perfil">
            <span>Mi Perfil</span>
        </a>
        <a href="settings.html" class="settings-link"> <img src="{{asset('Imagenes/iconos/settings-icon.svg')}}" alt="Ajustes">
            <span>Ajustes</span>
        </a>
        <a href="wallet.html" class="settings-link"> <img src="{{asset('Imagenes/iconos/billing-icon.svg')}}" alt="Facturación">
            <span>Mi Billetera</span>
        </a>
    </div>
    <div class="settings-sidebar-footer">
        <a href="#" class="settings-link" id="logout-btn">
            <img src="{{asset('Imagenes/iconos/logout-icon.svg')}}" alt="Cerrar Sesión">
            <span>Cerrar Sesión</span>
        </a>
    </div>
</nav>
