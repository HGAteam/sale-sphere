@php
    $label = $label ?? trans('Submit');
    $message = $message ?? trans('Please wait').'...';
@endphp

<!--begin::Indicator-->
<span class="indicator-label">
    {{ $label }}
</span>
<span class="indicator-progress" style="display: none;">
    {{ $message }}
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
<!--end::Indicator-->
