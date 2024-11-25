@if (session()->has('success'))

<div class="alert alert-success fade show" role="alert" id="success-alert"
     style="position: fixed; top: 10px; left: 50%; transform: translateX(-50%); z-index: 1050; width: 400px; padding: 5px; overflow: hidden; text-align: center;">
    {{ session('success') }}
</div>

@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 3000);
        }
    });
</script>
