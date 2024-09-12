<x-default-layout>
    @section('title')
        Panel de control
    @endsection

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <!--begin::Col-->
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            @include('partials/widgets/cards/_widget-proyectos')
            @include('partials/widgets/cards/_widget-clientes')
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col">
            <div class="h-100 overflow-auto">
                @include('partials/widgets/cards/_widget-visitas')
            </div>
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->

    <!--begin::Row-->
    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
        <div class="col-xl-12">
            @include('partials/widgets/engage/_widget-productos')
        </div>
        <!--begin::Col-->
        <div class="col-xl-12">
            @include('partials/widgets/tables/_widget-populares')
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
@include('partials/modals/_detalles-proyecto')
</x-default-layout>
