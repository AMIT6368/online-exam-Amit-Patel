(function ($) {
  "use strict";

  var table;

  //datatables 
  table = $("#table").DataTable({
    language: {
      info: table_showing +
        " _START_ " +
        table_to +
        " _END_ " +
        table_of +
        " _TOTAL_ " +
        table_entries,
      sLengthMenu: table_show + " _MENU_ " + table_entries,
      sSearch: table_search,
      paginate: {
        previous: table_previous,
        next: table_next,
      },
    },

    processing: true, //Feature control the processing indicator.
    serverSide: true, //Feature control DataTables' server-side processing mode.
    order: [], //Initial no order.
    ajax: {
      url: BASE_URL + "admin/payment/payment-list",
      type: "POST",
    },

    //Set column definition initialisation properties.
    columnDefs: [{
      targets: [0], //first column / numbering column
      orderable: false, //set not orderable
    }, ],
  });
  
  

  $(document).on('click', '.pay-status', function(e) {
  	var payment_id = $(this).data('payment_id');
  	var status_value = $('.pay-change-'+payment_id).val();
  	e.preventDefault();
  	
    swal({
        title: are_you_sure,
        text: 'Change Status',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
      },
      function (isConfirm) {
        if (isConfirm == true) {
          $.ajax({
          	url:BASE_URL+"admin/payment/update-status",
          	type:"POST",
          	data:{payment_id:payment_id,status_value:status_value},
          	success: function (response)
          	{
          		response = JSON.parse(response);
         		console.log(response.status);
         		if(response.status)
         		{
         			$.notify({
				      // options
				      message: "Status updated for payment",
				      target: "_blank",
				    }, {
				      // settings
				      element: "body",
				      placement: {
				        from: "top",
				        align: "right",
				      },
				      offset: 20,
				      spacing: 10,
				      z_index: 1031,
				      delay: 5000,
				      timer: 1000,
				    });
         		}
          	},
          	error: function(e)
          	{
          		console.log(e);
          	}
          });
        }
      }
    );  
  	
  });

  
    $(document).on("click",".myBtn",function(){
		var payment_id = $(this).data("payment_id");
		$.ajax({
          	url:BASE_URL+"admin/payment/payment-detail",
          	type:"POST",
          	data:{payment_id:payment_id},
          	success: function (response)
          	{
          		response = JSON.parse(response);
          		$('#myModal').modal('show');
          		$('.payment-data').html(response);
              $('.invoice-bill').attr("href", BASE_URL+"admin/payment/invoice/"+payment_id);
          	},
          	error: function(e)
          	{
          		console.log(e);
          	}
        });    	
         
    });

    $("input[name='save']").on("click", function(){
    	var event = $(this);
    	var quiz_id = $('.quiz_id').val();
    	var title = $("input[name=plan_name]").val();
    	var price = $('.quiz-price').val();
    	var transaction_no = $('#transaction-no').val();
    	if($(this).hasClass('save-data'))
    	{
    		
    		$.ajax({ 
	          	url:BASE_URL+"quiz-pay/bank-transfer-insert",
	          	type:"POST",
	          	data:{quiz_id:quiz_id,transaction_no:transaction_no,title:title,price:price},
	          	success: function (response)
	          	{
	          		response = JSON.parse(response);
	          		console.log(response);
	          		if(response.success)
	          		{
	          			window.location.href = BASE_URL+('quiz-pay/payment-mode/'+quiz_id);
	          		}
	          		else if(response.empty == 'error')
	          		{
	          			$('.bank').html('Please fill transaction number');
	          		}
	          	},
	          	error: function(e)
	          	{
	          		console.log(e);
	          	}
	        });
    	}
    	else
    	{
    		if($(this).hasClass('update-data'))
    		{
    			$.ajax({
		          	url:BASE_URL+"quiz-pay/bank-transfer-update",
		          	type:"POST",
		          	data:{quiz_id:quiz_id,transaction_no:transaction_no,title:title,price:price},
		          	success: function (response)
		          	{
		          		response = JSON.parse(response);
		          		console.log(response);
		          		if(response.success)
		          		{
		          			window.location.href = BASE_URL+('quiz-pay/payment-mode/'+quiz_id);
		          		}
		          		else if(response.empty == "error")
		          		{
		          			$('.bank').html('Please fill transaction number');
		          		}
		          	},
		          	error: function(e)
		          	{
		          		console.log(e);
		          	}
		        });		
    		}	
    	}
    });	
})(jQuery);  