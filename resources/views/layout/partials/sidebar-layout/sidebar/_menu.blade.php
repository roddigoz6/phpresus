<div class="app-sidebar-menu oflow-hidden flex-column-fluid">
	<div id="kt_app_sidebar_menu_wrapper" class="pp-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
		<div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-icon"><i class="fa-solid fa-toolbox"></i></span>
                    <span class="menu-title">Proyectos </span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion">

                    <div class="menu-item">
                        <a class="menu-link ? 'active' : '' }}" href="{{ route('proyecto.index') }}">
                            <span class="menu-bullet">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </span>
                            <span class="menu-title">Ver proyectos</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link ? 'active' : '' }}" href="{{ route('visita.index') }}">
                            <span class="menu-bullet">
                                <i class="fa-solid fa-calendar-check"></i>
                            </span>
                            <span class="menu-title">Ver visitas</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link ? 'active' : '' }}" href="{{ route('factura.index') }}">
                            <span class="menu-bullet">
                                <i class="fas fa-euro-sign"></i>
                            </span>
                            <span class="menu-title">Ver facturas <span class="menu-icon"></span>
                        </span>
                        </a>
                    </div>

                </div>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion ? 'active' : '' }}">
                <a href="{{ route('producto.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="fas fa-hammer"></i></span>
                    <span class="menu-title">Productos</span>
                </a>
            </div>

            <div data-kt-menu-trigger="click" class="menu-item menu-accordion ? 'active' : '' }}">
                <a href="{{ route('cliente.index') }}" class="menu-link">
                    <span class="menu-icon"><i class="far fa-user"></i></span>
                    <span class="menu-title">Clientes</span>
                </a>
            </div>

        </div>
	</div>
</div>
