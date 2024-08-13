<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-auto" data-kt-menu="true" id="userAccountMenu">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center justify-content-between px-3">
            <!--begin::User Initial & Name-->
            <div class="d-flex align-items-center">
                <div class="symbol symbol-50px me-5">
                    <div id="userInitial" class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>

                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name}}</div>
                    <a href={{route('user.index')}} class="fw-semibold text-muted text-hover-primary fs-7" data-bs-toggle="popover" data-bs-trigger="hover" title="Ver ajustes de cuenta">{{ Auth::user()->email }}</a>
                </div>
                <!--end::Username-->
            </div>
            <!--end::User Initial & Name-->
        </div>
    </div>
</div>
<!--end::User account menu-->
@push('scripts')
<script>
$(document).ready(function() {
    var initialContent = $('#userInitial').html();

    $('#userInitial').hover(
        function() {
            $('#userInitial').fadeOut(100, function() {
                //El data-bs-toggle="popover" data-bs-trigger="hover" title="Cerrar sesión" aquí no queda igual que el que está arriba
                var logoutForm = `
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="border: none; background: none; padding: 0; margin: 0;">
                            <i class="fa-solid fa-right-from-bracket" style="font-size: inherit;"></i>
                        </button>
                    </form>
                `;
                $(this).html(logoutForm).fadeIn(100);
                $(this).addClass('btn btn-light-danger');
            });
        },
        function() {
            $('#userInitial').fadeOut(100, function() {
                $(this).html(initialContent).fadeIn(100);
            });
        }
    );
});

</script>
@endpush
