<form id="contact">
    @csrf
    <div class="form-group">
        <label>Ad/Soyad</label>
        <input type="text" class="form-control" name="full_name" placeholder="Ad/Soyad" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email" required>
    </div>
    <div class="form-group mb--40">
        <label>Telefon</label>
        <input type="tel" class="form-control" name="phone" placeholder="+123456789" required>
    </div>
    <div class="form-group mb--40">
        <label>İsmarıc</label>
        <textarea class="form-control" name="message" placeholder="İsmarıc" required></textarea>
    </div>
    <input type="hidden" name="type" value="{{ $type }}">
    <div class="form-group">
        <button type="submit" class="axil-btn btn-fill-primary btn-fluid">Göndər</button>
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
        $(document).ready(function() {
            $("#contact").submit(function(e) {
                e.preventDefault()
                let data = $(this).serialize()
                $.post('contact', data, function(response) {
                    if (response.status == 201) {
                        console.log(response);
                        $("form").trigger("reset");
                        Toast.fire({
                            icon: "success",
                            title: response.message
                        });
                    }
                })
            });
        })
    </script>
@endpush
