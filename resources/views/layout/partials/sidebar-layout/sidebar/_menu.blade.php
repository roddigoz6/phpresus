<div class="app-sidebar-menu oflow-hidden flex-column-fluid">
	<div id="kt_app_sidebar_menu_wrapper" class="pp-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="false" data-kt-scroll-activate="false" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('presupuesto.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-box-open"></i></span>
                    <span class="menu-title">Proyectos</span>
                </a>
            </div>
        </div>

        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('factura.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-euro-sign"></i></span>
                    <span class="menu-title">Visitas</span>
                </a>
            </div>
        </div>

		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('factura.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-euro-sign"></i></span>
                    <span class="menu-title">Facturas</span>
                </a>
            </div>
        </div>

		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('producto.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-hammer"></i></span>
                    <span class="menu-title">Productos</span>
                </a>
            </div>
        </div>

		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('cliente.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="far fa-user"></i></span>
                    <span class="menu-title">Clientes</span>
                </a>
            </div>
        </div>

	</div>
</div>
