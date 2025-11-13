<form class="contact-form js-contact-form" method="POST" action="{{ route('contact.submit') }}">
    @csrf
    <div class="form-group">
        <label>{{ __('front.contact.full_name') }}</label>
        <input type="text" class="form-control" name="full_name" placeholder="{{ __('front.contact.full_name') }}"
            required>
    </div>
    <div class="form-group">
        <label>{{ __('front.contact.email') }}</label>
        <input type="email" class="form-control" name="email" placeholder="{{ __('front.contact.email') }}" required>
    </div>
    <div class="form-group mb--40">
        <label>{{ __('front.contact.phone') }}</label>
        <input type="tel" class="form-control" name="phone" placeholder="+123456789" required>
    </div>
    <div class="form-group mb--40">
        <label>{{ __('front.contact.message') }}</label>
        <textarea class="form-control" name="message" placeholder="{{ __('front.contact.message') }}" required></textarea>
    </div>
    <input type="hidden" name="type" value="{{ $type }}">
    <div class="form-group">
        <button type="submit" class="axil-btn btn-fill-primary btn-fluid">{{ __('front.contact.submit') }}</button>
    </div>
</form>
@push('js_script')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
    </script>
    <script>
        $(function() {
            $('.js-contact-form').each(function() {
                const $form = $(this);
                const $submitButton = $form.find('button[type="submit"]');

                $form.on('submit', function(e) {
                    e.preventDefault();
                    $submitButton.prop('disabled', true);

                    $.post($form.attr('action'), $form.serialize())
                        .done(function(response) {
                            if (response.status === 201) {
                                $form.trigger('reset');
                                Toast.fire({
                                    icon: "success",
                                    title: response.message
                                });
                            }
                        })
                        .fail(function(xhr) {
                            let message = "{{ __('front.contact.error_message') }}";

                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.message) {
                                    message = xhr.responseJSON.message;
                                } else if (xhr.responseJSON.errors) {
                                    const firstKey = Object.keys(xhr.responseJSON.errors)[0];
                                    if (firstKey && xhr.responseJSON.errors[firstKey][0]) {
                                        message = xhr.responseJSON.errors[firstKey][0];
                                    }
                                }
                            }

                            Toast.fire({
                                icon: "error",
                                title: message
                            });
                        })
                        .always(function() {
                            $submitButton.prop('disabled', false);
                        });
                });
            });
        });
    </script>
@endpush
