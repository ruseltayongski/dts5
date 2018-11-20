<script>
    $(document).ready(function() {

        var countIncoming = 0;
        var countOutgoing = 0;
        var countUnconfirm = 0;

        $('.btn-return').on('click',function(e) {
            e.preventDefault();
            var id = $(this).closest('.list-group-item').data('id');
            $('#return_remarks').val(null);
            $('#returnRemark').data('id',id).modal('show');
        });

        $('.confirmReturn').click(function(){
            var id = $('#returnRemark').data('id');
            var remarks = $('#return_remarks').val();
            var _token = "{{ csrf_token() }}";
            $('[data-id=' + id + ']').addClass('hide');
            $('.loading').show();
            var url = "<?php echo url('document/pending/return');?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id:id,
                    remarks:remarks,
                    _token: _token
                },
                success: function(data){
                    console.log(data);
                    countIncoming += 1;
                    var count = incomingFunction();
                    $('.badgeIncoming').html(count-countIncoming);
                    Lobibox.notify('success', {
                        msg: 'Returned successfully!'
                    });
                    $('.loading').hide();
                }
            });
        });

        $('.btn-accept').on('click',function(e){
            e.preventDefault();
            var id = $(this).closest('.list-group-item').data('id');
            $('#accept_remarks').val(null);
            $('#acceptModal').data('id',id).modal('show');
        });

        $('.confirmAccept').click(function(){
            var id = $('#acceptModal').data('id');
            var remarks = $('#accept_remarks').val();
            var _token = "{{ csrf_token() }}";
            $('[data-id=' + id + ']').addClass('hide');
            $('.loading').show();
            var url = "<?php echo url('document/pending/accept');?>";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    id:id,
                    remarks:remarks,
                    _token: _token
                },
                success: function(data){
                    console.log(data);
                    countIncoming += 1;
                    var count = incomingFunction();
                    $('.badgeIncoming').html(count-countIncoming);
                    Lobibox.notify('success', {
                        msg: 'Accepted successfully!'
                    });
                    $('.loading').hide();
                }
            });
        });

        $('.btn-cancel').click(function(e){
            e.preventDefault();
            var id = $(this).closest('.list-group-item').data('id');
            console.log(id);
            $('#cancelModal').data('id',id).modal('show');
        });

        $('.btn-alert').click(function(){
            var id = $(this).closest('.list-group-item').data('id');
            var url = "<?php echo url('document/alert/1');?>/"+id;
            console.log(url);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(dataJim){
                    console.log(dataJim);
                    Lobibox.notify('success', {
                        msg: 'A notification has been sent!'
                    });
                }
            });

            $(this).fadeOut();

        });

        $('.btn-alert2').click(function(){
            var id = $(this).closest('.list-group-item').data('id');
            var url = "<?php echo url('document/alert/2');?>/"+id;
            console.log(url);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(dataJim){
                    console.log(dataJim);
                    Lobibox.notify('success', {
                        msg: 'A notification has been sent!'
                    });
                }
            });

            $(this).fadeOut();

        });

        $('.btn-report').click(function(){
            var id = $(this).closest('.list-group-item').data('id');
            var url = "<?php echo url('document/alert/3');?>/"+id;
            console.log(url);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(dataJim){
                    console.log(dataJim);
                    Lobibox.notify('warning', {
                        msg: 'This document has been reported!'
                    });
                }
            });

            $(this).fadeOut();

        });

        $('.confirmCancel').click(function(){
            var id = $('#cancelModal').data('id');
            $('[data-id=' + id + ']').addClass('hide');
            $('.loading').show();
            var url = "<?php echo url('document/report');?>";
            $.ajax({
                url: url+'/'+id+'/cancel',
                type: 'GET',
                success: function(){
                    countUnconfirm += 1;
                    var count = uncofirmFunction();
                    $('.badgeUnconfirm').html(count-countUnconfirm);
                    Lobibox.notify('success', {
                        msg: 'Cancelled successfully!'
                    });
                    $('.loading').hide();
                }
            });
        });

        $('.btn-end').click(function(e){
            e.preventDefault();
            var id = $(this).closest('.list-group-item').data('id');
            $('#removeModal').data('id',id).modal('show');
        });

        $('.confirmRemove').click(function(){
            var id = $('#removeModal').data('id');
            $('[data-id=' + id + ']').addClass('hide');
            $('.loading').show();
            var url = "<?php echo url('document/removepending');?>";
            $.ajax({
                url: url+'/'+id,
                type: 'GET',
                success: function(data){
                    countOutgoing += 1;
                    var count = outgoingFunction();
                    $('.badgeOutgoing').html(count-countOutgoing);
                    Lobibox.notify('success', {
                        msg: 'Cycle end!'
                    });
                    $('.loading').hide();
                }
            });
        });
    } );


    $('.filter-division').on('change',function(){
        checkDestinationForm();
        var id = $(this).val();
        var url = "<?php echo asset('getsections/');?>";
        $('.loading').show();
        $('.filter_section').html('<option value="">Select section...</option>')
        $.ajax({
            url: url+'/'+id,
            type: "GET",
            success: function(sections){
                jQuery.each(sections,function(i,val){
                    $('.filter_section').append($('<option>', {
                        value: val.id,
                        text: val.description
                    }));
                    $('.filter_section').chosen().trigger('chosen:updated');
                    $('.filter_section').siblings('.chosen-container').css({border:'2px solid red'});
                });
                $('.loading').hide();
            }
        })
    });
    $('.filter_section').on('change',function(){
        checkDestinationForm();
    });

    function putRoute(form)
    {
        var route_no = form.data('route_no');
        $('#route_no').val(route_no);
        $('#op').val(0);
        $('#currentID').val(form.data('id'));
    }

    function changeRoute(form,id)
    {
        var route_no = form.data('route_no');
        $('#route_no').val(route_no);
        $('#op').val(id);
    }
    function checkDestinationForm(){
        var division = $('.filter-division').val();
        var section = $('.filter_section').val();
        if(division.length == 0){
            $('.filter-division').siblings('.chosen-container').css({border:'2px solid red'});
        }else{
            $('.filter-division').siblings('.chosen-container').css({border:'none'});
        }

        if(section.length == 0){
            $('.filter_section').siblings('.chosen-container').css({border:'2px solid red'});
        }else{
            $('.filter_section').siblings('.chosen-container').css({border:'none'});
        }
    }
    function checkDocTye(){
        var doc = $('select[name="doc_type"]').val();
        if(doc.length == 0){
            $('.error').removeClass('hide');
        }
    }

    function incomingFunction() {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('incomingInput');

        console.log(input.value);

        filter = input.value.toUpperCase();
        ul = document.getElementById("incomingUL");
        li = ul.getElementsByTagName("li");


        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            //a = li[i].getElementsByTagName("a")[0];
            a = li[i].innerHTML;
            if (a.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
        return li.length;
    }

    function outgoingFunction() {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('outgoingInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("outgoingUL");
        li = ul.getElementsByTagName("li");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            //a = li[i].getElementsByTagName("a")[0];
            a = li[i].innerHTML;
            if (a.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
        return li.length;
    }

    function uncofirmFunction() {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('uncofirmInput');
        filter = input.value.toUpperCase();
        ul = document.getElementById("uncofirmUL");
        li = ul.getElementsByTagName("li");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < li.length; i++) {
            //a = li[i].getElementsByTagName("a")[0];
            a = li[i].innerHTML;
            if (a.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
        return li.length;
    }
</script>