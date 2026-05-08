<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<style>
    .spinner-xs {
        width: 1rem !important;
        height: 1rem !important;
        border-width: 0.125rem !important; /* thinner border for small spinner */
    }

    .spinner-sm {
        width: 1.5rem !important;
        height: 1.5rem !important;
        border-width: 0.2rem !important;
    }

    .spinner-md {
        width: 2rem !important;
        height: 2rem !important;
        border-width: 0.25rem !important;
    }

    .spinner-lg {
        width: 3rem !important;
        height: 3rem !important;
        border-width: 0.3rem !important;
    }

    .spinner-xl {
        width: 4rem !important;
        height: 4rem !important;
        border-width: 0.35rem !important; 
    }
    .text-justified {
        text-align: justify !important;
    }

</style>
<div class="modal fade" tabindex="-1" id="notification_modal">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 360px;">
        <div class="modal-content border-0">
            <div class="modal-header border-bottom-0 pb-0 px-4 pt-4">
                <div>
                    <h5 class="modal-title fw-semibold" id="notification_title">Notification</h5>
                    <p class="text-muted small mb-0 mt-1">Please wait...</p>
                </div>
                <button type="button" tabindex="-1" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4 text-center">
                <div class="mb-3" id="notification_spinner">
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <p class="text-muted small mb-0" id="notification_body"></p>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    String.prototype.UCwords = function() {
        return this.replace(/[\wñÑáéíóúÁÉÍÓÚüÜ]+/g, function(a){ 
            return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase()
        })
    }
    String.prototype.UCfirst = function() {
        return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase()
    }
    String.prototype.isNumber = function() {
        return /^\d+$/.test(this);
    }
    String.prototype.dateWords = function() {
        words_date = new Date(this);
        long_date = words_date.toLocaleDateString('en-us', {year:"numeric", month:"long"})
        return long_date;
    }
    function load_notification(title, message, status) {
        $('#notification_spinner').removeClass('text-danger text-success text-primary')
        $('#notification_status').removeClass('text-danger text-success text-primary')
        if (status == 'error') {
            status_class = 'text-danger';
        }
        else if (status == 'success') {
            status_class = 'text-success';
        }
        else if (status == 'neutral') {
            status_class = 'text-primary';
        }

        if (status == 'none') {
            $('#notification_spinner').addClass('d-none');
        }
        else {
            $('#notification_spinner').removeClass('d-none');
            $('#notification_spinner').addClass(status_class);
            $('#notification_status').addClass(status_class);
        }

        
        const notification_modal = $('#notification_modal');

        notification_modal.find('#notification_title').text(title);
        notification_modal.find('#notification_body').html(message);

        notification_modal.off('shown.bs.modal').on('shown.bs.modal', function () {
            $('#login_button').focus();
        });

        const notification_instance = new bootstrap.Modal(notification_modal[0]);
        notification_instance.show();
    }

</script>