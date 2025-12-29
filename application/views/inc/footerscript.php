<script src="<?= base_url('assets/js/main.js'); ?>"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

<!--notifications-->
<script src="<?= base_url('assets/notifications/js/lobibox.min.js'); ?>"></script>
<script src="<?= base_url('assets/notifications/js/notifications.min.js'); ?>"></script>
<script src="<?= base_url('assets/notifications/js/notification-custom-script.js'); ?>"></script>

<script>
    //form fields validation
    function fieldsValidate(fields){
        let ret = true;
        for (let i = 0; i < fields.length; i++) {
            if(!$('#'+fields[i]).val()){
                AlertToastMaxi('error', 'top right', fields[i]+' field is compulsory');
                ret = false;
            }
        }
        return ret;
    }
</script>